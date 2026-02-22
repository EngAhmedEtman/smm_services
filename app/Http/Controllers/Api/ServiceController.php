<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use App\Services\SmmService;
use App\Services\AdminNotificationService;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class ServiceController extends Controller
{
    protected $smmService;

    /**
     * Dependency Injection for SmmService
     * @param SmmService $smmService
     */
    public function __construct(SmmService $smmService)
    {
        $this->smmService = $smmService;
    }

    /**
     * Display the order form page.
     * Fetches available services from the SMM provider.
     */
    public function showForm()
    {
        $services = $this->smmService->getServicesWithSettings(true);
        $mainCategories = \App\Models\MainCategory::where('is_active', true)->orderBy('sort_order')->get();
        return view('services.ServicesPage', compact('services', 'mainCategories'));
    }

    /**
     * Display all services with pagination and favorites.
     * Handles listing, pagination, and marking favorite services.
     */
    public function allServices(Request $request)
    {
        $services = $this->smmService->getServicesWithSettings(true);

        // 1. Paginate the services array directly to respect provider order
        $paginatedServices = $this->paginateArray($services, $request, 100);

        // 2. Get User's Favorite Service IDs
        $favoriteIds = $this->getUserFavoriteIds();

        return view('services.AllServices', compact('paginatedServices', 'favoriteIds', 'services'));
    }

    /**
     * Display public services list for guests.
     */
    public function publicList(Request $request)
    {
        // No need to fetch all services for the landing page style
        return view('public-services', ['categories' => []]);
    }

    /**
     * Handle the creation of a new order.
     * Validates input, calculates cost, checks balance, creates local order, and sends to API.
     */
    public function addOrder(Request $request)
    {
        // 0. Prevent Double Submission (Idempotency Check)
        // Lock based on user ID + order content hash (service + link + quantity)
        // This prevents the same exact order from being submitted twice even in race conditions.
        $orderHash = md5($request->service . '|' . $request->link . '|' . $request->quantity . '|' . $request->comments);
        $lockKey = 'add_order_lock_' . auth()->id() . '_' . $orderHash;
        if (!\Illuminate\Support\Facades\Cache::add($lockKey, true, 10)) {
            return response()->json(['status' => 'error', 'error' => 'يرجى الانتظار قليلاً قبل إرسال طلب آخر.'], 429);
        }

        // 1. Retrieve Service Information
        $serviceInfo = $this->getServiceInfo((int)$request->service);
        if (!$serviceInfo) {
            return response()->json(['status' => 'error', 'error' => 'Service not found'], 404);
        }

        // 2. Validation
        $validationResult = $this->validateOrderRequest($request, $serviceInfo);
        if ($validationResult !== true) {
            return $validationResult; // Returns error response if validation fails (custom logic)
        }

        // 3. Calculation & Processing (Quantity, Charge)
        $processedData = $this->processOrderData($request, $serviceInfo);
        if (isset($processedData['error'])) {
            return response()->json(['status' => 'error', 'error' => $processedData['error']], 422);
        }

        // 4. Check Balance
        if (!$this->checkUserBalance($processedData['charge'])) {
            return response()->json([
                'status' => 'error',
                'error' => 'رصيدك غير كافي لإتمام هذا الطلب. يرجى شحن حسابك.',
            ], 422);
        }

        // 5. Create Local Order
        $order = $this->createLocalOrder($request, $processedData, $serviceInfo);

        // 6. Check if Custom Service
        if (isset($serviceInfo['is_custom']) && $serviceInfo['is_custom']) {
            // Deduct balance manually (since we bypass API submission)
            $this->deductUserBalance($processedData['charge']);

            // Notify Admin via WhatsApp
            try {
                AdminNotificationService::notifyNewCustomOrder($order);
            } catch (\Exception $e) {
                Log::error("Failed to notify admin about custom order: " . $e->getMessage());
            }

            return response()->json([
                'status' => 'success',
                'message' => 'تم استلام طلبك المخصص بنجاح وجاري تنفيذه.',
                'local_order_id' => $order->id
            ]);
        }

        // 7. Submit to SMM Provider (for non-custom services)
        return $this->submitOrderToProvider($order, $request->all(), $processedData['charge']);
    }

    /**
     * Display the user's order status page.
     * Refreshes order statuses from API before displaying.
     */
    public function status(Request $request)
    {
        // 1. Sync orders with SMM API
        $this->refreshUserOrders();

        // 2. Fetch and display orders
        $orders = auth()->user()->orders()->with('service')->latest()->get();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'orders' => $orders
            ]);
        }
        return view('services.status', compact('orders'));
    }

    /**
     * Handle order refill request.
     */
    public function refillOrder(Order $order)
    {
        $result = $this->smmService->refill($order->smm_order_id);

        if (isset($result['refill'])) {
            $order->update([
                'last_refill_id' => $result['refill'],
                'last_refill_status' => 'pending'
            ]);

            return back()->with('success', 'تم طلب إعادة التعبئة بنجاح (Refill ID: ' . $result['refill'] . ')');
        }

        return back()->with('error', 'خطأ في إعادة التعبئة: ' . ($result['error'] ?? 'خطأ غير معروف'));
    }

    /**
     * Handle order cancellation request.
     */
    public function cancelOrder(Order $order)
    {
        $result = $this->smmService->cancel($order->smm_order_id);

        if (isset($result['cancel'])) {
            $this->processOrderCancellation($order);
            return back()->with('success', 'تم إلغاء الطلب ورد المبلغ إلى رصيدك بنجاح.');
        }

        return back()->with('error', 'خطأ في إلغاء الطلب: ' . ($result['error'] ?? 'خطأ غير معروف'));
    }

    // =========================================================================
    // PRIVATE HELPER METHODS (Refactoring)
    // =========================================================================

    /**
     * Helper to paginate an array of items.
     */
    private function paginateArray(array $items, Request $request, int $perPage)
    {
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $perPage;
        $slicedItems = array_slice($items, $offset, $perPage);

        return new LengthAwarePaginator(
            $slicedItems,
            count($items),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    }

    /**
     * Get the list of favorite service IDs for the authenticated user.
     */
    private function getUserFavoriteIds(): array
    {
        if (!auth()->check()) {
            return [];
        }
        return auth()->user()->favoriteServices()
            ->pluck('service_id')
            ->map(fn($id) => (int)$id)
            ->toArray();
    }

    /**
     * Find service details by ID from the fetched services list.
     */
    private function getServiceInfo(int $serviceId)
    {
        $allServices = $this->smmService->services();
        return collect($allServices)->firstWhere('service', $serviceId);
    }

    /**
     * Dynamic validation based on service type.
     */
    private function validateOrderRequest(Request $request, array $serviceInfo)
    {
        $type = $serviceInfo['type'] ?? 'Default';
        $rules = [
            'service' => 'required|integer',
            'link' => 'required|url',
        ];

        if ($this->isCustomComments($type)) {
            $rules['comments'] = 'required|string';
        } elseif ($type !== 'Package') {
            $rules['quantity'] = 'required|numeric|min:1';
        }

        // Use built-in validation which throws ParsingException on failure, or could return validator
        $request->validate($rules);

        return true;
    }

    /**
     * Calculate quantity and charge based on service type and input.
     * Handles specific logic for Custom Comments and Packages.
     */
    private function processOrderData(Request $request, array $serviceInfo)
    {
        $type = $serviceInfo['type'] ?? 'Default';
        $data = [
            'quantity' => $request->quantity,
            'charge' => $request->charge
        ];

        if ($this->isCustomComments($type)) {
            $comments = $request->comments;
            // Clean comments: remove empty lines
            $lines = array_filter(preg_split('/\r\n|\r|\n/', $comments), function ($line) {
                return trim($line) !== '';
            });
            $count = count($lines);

            if ($count < 1) {
                return ['error' => 'Please add at least one comment.'];
            }

            $data['quantity'] = $count;
            // Re-calculate local charge for safety
            $data['charge'] = ($data['quantity'] / 1000) * $serviceInfo['rate'];

            // Merge into request for API use later
            $request->merge(['quantity' => $data['quantity'], 'charge' => $data['charge']]);
        } elseif ($type === 'Package') {
            if (!$data['quantity']) {
                $data['quantity'] = 1;
                $request->merge(['quantity' => 1]);
            }
        }

        return $data;
    }

    /**
     * Create a pending order record in the local database.
     */
    private function createLocalOrder(Request $request, array $processedData, array $serviceInfo)
    {
        return Order::create([
            'user_id' => auth()->id(),
            'service_id' => $request->service,
            'service_name' => $serviceInfo['name'] ?? 'Unknown Service',
            'link' => $request->link,
            'quantity' => $processedData['quantity'],
            'status' => 'pending', // Initial status
            'price' => $processedData['charge'],
            'refill_available' => $serviceInfo['refill'] ?? false,
            'cancel_available' => $serviceInfo['cancel'] ?? false,
        ]);
    }

    /**
     * Send order to external SMM provider and update local order.
     */
    private function submitOrderToProvider(Order $order, array $requestData, $charge)
    {
        $result = $this->smmService->addOrder($requestData);

        if (isset($result['order'])) {
            // Success
            $order->update([
                'smm_order_id' => $result['order'],
                'start_count'  => $result['start_count'] ?? 0,
                'remains'      => $result['remains'] ?? $order->quantity,
                'status'       => 'processing'
            ]);

            // Deduct balance
            $this->deductUserBalance($charge);

            return response()->json([
                'message' => 'Order processed',
                'api_response' => $result,
                'local_order_id' => $order->id
            ]);
        } else {
            // Failure
            $order->update([
                'status' => 'failed',
                'error_log' => json_encode($result)
            ]);

            return response()->json([
                'message' => 'Failed to create order on provider',
                'api_response' => $result,
            ], 422);
        }
    }

    /**
     * Deduct amount from user balance and update total spent.
     */
    private function deductUserBalance($amount)
    {
        $user = auth()->user();
        $user->balance -= $amount;
        $user->total_spent += $amount;
        $user->save();
    }

    /**
     * Process local cancellation: refund balance and update status.
     */
    private function processOrderCancellation(Order $order)
    {
        $order->update([
            'status' => 'canceled',
            'cancel_available' => false
        ]);

        $user = auth()->user();
        $user->balance += $order->price;
        // Optionally decrease total spent
        // $user->total_spent -= $order->price; 
        $user->save();
    }

    /**
     * Check if user has enough balance.
     */
    private function checkUserBalance($amount)
    {
        return auth()->user()->balance >= $amount;
    }

    private function isCustomComments($type)
    {
        return $type === 'Custom Comments' || $type === 'Custom Comments Package';
    }

    /**
     * Logic to refresh user orders from the external API.
     * Syncs order status, remains, start_count, and refill status.
     */
    private function refreshUserOrders()
    {
        // 1. Get Orders needing update
        $ordersToUpdate = $this->getOrdersForUpdate();

        if ($ordersToUpdate->isEmpty()) {
            return;
        }

        // 2. Sync their statuses
        $this->syncOrderStatuses($ordersToUpdate);

        // 3. Sync Refill statuses separately
        $this->syncRefillStatuses();
    }

    /**
     * Retrieve local orders that should be checked for updates.
     */
    private function getOrdersForUpdate()
    {
        // 1. Always check these active statuses
        $activeStatuses = ['pending', 'processing', 'inprogress', 'in progress', 'partial'];

        $activeOrders = auth()->user()->orders()
            ->whereIn('status', $activeStatuses)
            ->whereNotNull('smm_order_id')
            ->get();

        // 2. Check canceled orders only from the last 48 hours
        // This prevents checking old canceled orders repeatedly
        $recentCanceled = auth()->user()->orders()
            ->whereIn('status', ['canceled', 'cancelled'])
            ->whereNotNull('smm_order_id')
            ->where('updated_at', '>=', now()->subHours(48))
            ->get();

        // 3. Check completed orders from the last 24 hours (for refill updates)
        $recentCompleted = auth()->user()->orders()
            ->where('status', 'completed')
            ->whereNotNull('smm_order_id')
            ->where('updated_at', '>=', now()->subDay())
            ->get();

        return $activeOrders->merge($recentCanceled)->merge($recentCompleted)->unique('id');
    }

    /**
     * Bulk fetch status from API and update local orders.
     */
    private function syncOrderStatuses($orders)
    {
        $apiOrderIds = $orders->pluck('smm_order_id')->filter()->toArray();

        if (empty($apiOrderIds)) {
            return;
        }

        try {
            $apiResults = $this->smmService->getMultipleOrdersStatus($apiOrderIds);
            Log::info('SMM API Response for Order Status IDs (' . implode(',', $apiOrderIds) . '):', ['response' => $apiResults]);

            foreach ($orders as $order) {
                $this->updateSingleOrder($order, $apiResults);
            }
        } catch (\Exception $e) {
            Log::error('Failed to refresh orders from API: ' . $e->getMessage());
        }
    }

    /**
     * Update a single order based on the bulk API response.
     */
    private function updateSingleOrder($order, $apiResults)
    {
        $externalId = $order->smm_order_id;

        if (!isset($apiResults[$externalId])) {
            return;
        }

        $apiStatus = $apiResults[$externalId];

        // Gracefully handle errors in response (e.g., "Incorrect order ID")
        if (isset($apiStatus['error'])) {
            Log::warning("SMM API Error for Order {$externalId}: " . $apiStatus['error']);
            return;
        }

        if (isset($apiStatus['status'])) {
            $order->update([
                'status'  => strtolower($apiStatus['status']),
                'remains' => $apiStatus['remains'] ?? $order->remains,
                'start_count' => !empty($apiStatus['start_count']) ? $apiStatus['start_count'] : $order->start_count,
                'refill_available' => $apiStatus['refill'] ?? false,
                'cancel_available' => $apiStatus['cancel'] ?? false,
            ]);
        }
    }

    /**
     * Check and update status for orders with pending refills.
     */
    private function syncRefillStatuses()
    {
        $ordersWithRefill = auth()->user()->orders()
            ->whereNotNull('last_refill_id')
            ->where(function ($q) {
                $q->whereNull('last_refill_status')
                    ->orWhereNotIn('last_refill_status', ['Rejected', 'Canceled', 'Error']);
            })
            ->get();

        if ($ordersWithRefill->isEmpty()) {
            return;
        }

        $refillIds = $ordersWithRefill->pluck('last_refill_id')->unique()->toArray();

        try {
            $refillResults = $this->smmService->multipleRefillStatus($refillIds);

            foreach ($ordersWithRefill as $order) {
                $rid = $order->last_refill_id;
                if (isset($refillResults[$rid]['status'])) {
                    $order->update(['last_refill_status' => $refillResults[$rid]['status']]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to refresh refill status: ' . $e->getMessage());
        }
    }
}
