<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use App\Services\SmmService;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\Facades\Log;


class ServiceController extends Controller
{

    protected $smmService;

    /**
     * @param SmmService $smmService
     */

    public function __construct(SmmService $smmService)
    {
        $this->smmService = $smmService;
    }



    public function showForm()
    {
        $services = $this->smmService->services(); // تجيب الداتا من API

        return view('services.ServicesPage', compact('services'));
    }




    public function addOrder(Request $request)
    {
        $request->validate([
            'service' => 'required|integer',
            'link' => 'required|url',
            'quantity' => 'required|numeric|min:1',
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'service_id' => $request->service,
            'link' => $request->link,
            'quantity' => $request->quantity,
            'status' => 'pending',
            'price' => $request->charge,
        ]);


        $result = $this->smmService->addOrder($request->all());

        if (isset($result['order'])) {
            $order->update([
                'smm_order_id' => $result['order'], // رقم الطلب من المزود
                'start_count'  => $result['start_count'] ?? 0,
                'remains'      => $result['remains'] ?? $request->quantity,
                'status'       => 'processing'
            ]);
        } else {
            $order->update([
                'status' => 'failed',
                'error_log' => json_encode($result)
            ]);
        }

        return response()->json([
            'message' => 'Order processed',
            'api_response' => $result,
            'local_order_id' => $order->id
        ]);
    }




    public function status()
    {
        // 1. نحدث الطلبات أولاً
        $this->refreshUserOrders();

        // 2. نجيب البيانات من الداتا بيز بعد التحديث ونعرضها
        $orders = auth()->user()->orders()->latest()->get();

        return view('services.status', compact('orders'));
    }

    /**
     * وظيفة خاصة لتحديث حالات طلبات المستخدم الحالي من الـ API
     */
    private function refreshUserOrders()
    {
        // هات الطلبات اللي حالتها لسه مش نهائية (ليست مكتملة ولا ملغية)
        // ولها رقم طلب من المزود (smm_order_id)
        $activeOrders = auth()->user()->orders()
            ->whereIn('status', ['pending', 'processing', 'inprogress', 'in progress'])
            ->whereNotNull('smm_order_id') // فقط الطلبات اللي عندها رقم من المزود
            ->get();

        if ($activeOrders->isEmpty()) {
            return;
        }

        // استخراج الـ IDs وإرسالها للسيرفيس
        $apiOrderIds = $activeOrders->pluck('smm_order_id')->filter()->toArray();

        if (empty($apiOrderIds)) {
            return;
        }

        try {
            $apiResults = $this->smmService->getMultipleOrdersStatus($apiOrderIds);

            // تحديث كل طلب في الداتا بيز بناءً على رد الـ API
            foreach ($activeOrders as $order) {
                $externalId = $order->smm_order_id;

                if (isset($apiResults[$externalId])) {
                    $apiStatus = $apiResults[$externalId];

                    $order->update([
                        'status'  => strtolower($apiStatus['status']),
                        'remains' => $apiStatus['remains'] ?? $order->remains,
                        'start_count' => $apiStatus['start_count'] ?? $order->start_count,
                    ]);
                }
            }
        } catch (\Exception $e) {
            // في حالة فشل الاتصال بالـ API، نتجاهل الخطأ ونعرض البيانات من الداتا بيز
            Log::error('Failed to refresh orders from API: ' . $e->getMessage());
        }
    }
}
