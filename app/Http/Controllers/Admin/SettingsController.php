<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Recharge;
use App\Models\User;
use App\Models\Order;
use App\Models\PricingTier;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Show the admin settings page (WhatsApp notification config).
     */
    public function index()
    {
        $settings = Setting::pluck('value', 'key');
        $tiers = PricingTier::orderBy('min_count')->get();
        return view('settings.index', compact('settings', 'tiers'));
    }

    /**
     * Update notification settings.
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'admin_whatsapp_instance_id' => 'required|string',
            'admin_whatsapp_access_token' => 'required|string',
            'admin_receiver_number' => 'required|string',
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'تم تحديث إعدادات الإشعارات بنجاح.');
    }

    /**
     * Show all recharge requests.
     */
    public function recharges()
    {
        $recharges = Recharge::with('user')->latest()->get();
        return view('settings.recharges', compact('recharges'));
    }

    /**
     * Approve a recharge request and add balance.
     */
    public function approveRecharge($id)
    {
        $recharge = Recharge::findOrFail($id);

        if ($recharge->status !== 'pending') {
            return back()->with('error', 'هذا الطلب تمت مراجعته بالفعل.');
        }

        $recharge->update(['status' => 'approved']);

        // Notify User
        \App\Services\AdminNotificationService::notifyNewRechargeApproved($recharge);
        // Add balance to user
        $user = $recharge->user;
        $user->increment('balance', $recharge->amount);

        return back()->with('success', "تم قبول الطلب وإضافة {$recharge->amount} جنيه لرصيد {$user->name}.");
    }

    /**
     * Reject a recharge request.
     */
    public function rejectRecharge($id)
    {
        $recharge = Recharge::findOrFail($id);

        if ($recharge->status !== 'pending') {
            return back()->with('error', 'هذا الطلب تمت مراجعته بالفعل.');
        }

        $recharge->update(['status' => 'rejected']);

        return back()->with('success', 'تم رفض الطلب.');
    }

    /**
     * Show users management page.
     */
    /**
     * Show users management page.
     */
    public function users()
    {
        $users = User::latest()->get();
        return view('settings.users', compact('users'));
    }

    /**
     * Toggle user active status (Ban/Unban).
     */
    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);

        // Prevent banning yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', 'لا يمكنك حظر نفسك.');
        }

        if ($user->banned) {
            // Unban: Delete the record
            $user->banned()->delete();
            $message = "تم تفعيل العميل {$user->name} بنجاح.";
        } else {
            // Ban: Create the record
            $user->banned()->create(['reason' => 'Admin Action']);
            $message = "تم حظر العميل {$user->name} بنجاح.";
        }

        return back()->with('success', $message);
    }

    /**
     * Add credit to user active status.
     */
    public function addCredit(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'reason' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);

        $user->increment('balance', $request->amount);

        // Notify User via WhatsApp
        try {
            \App\Services\AdminNotificationService::notifyCreditAdded($user, $request->amount, $request->reason);
        } catch (\Exception $e) {
            // Log error but continue
            \Illuminate\Support\Facades\Log::error("Failed to send WhatsApp notification: " . $e->getMessage());
        }

        return back()->with('success', "تم إضافة {$request->amount} جنيه لرصيد {$user->name} بنجاح.");
    }

    /**
     * Show all orders from all users (Admin).
     * Statuses are fetched live from the SMM API for the current page.
     */
    public function orders(Request $request)
    {
        $query = Order::with('user')->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by user search
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            })->orWhere('link', 'like', '%' . $request->search . '%')
                ->orWhere('smm_order_id', 'like', '%' . $request->search . '%');
        }

        // Paginate 20 per page
        $orders = $query->paginate(20)->withQueryString();

        // Fetch live statuses from SMM API for orders that have a smm_order_id
        $smmIds = $orders->filter(fn($o) => !empty($o->smm_order_id))
            ->pluck('smm_order_id')
            ->toArray();

        $apiStatuses = [];
        if (!empty($smmIds)) {
            try {
                $smmService  = new \App\Services\SmmService();
                $apiStatuses = $smmService->getMultipleOrdersStatus($smmIds);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Admin orders: SMM API status fetch failed — ' . $e->getMessage());
            }
        }

        // Merge API status into each order item
        foreach ($orders as $order) {
            $apiData = $apiStatuses[$order->smm_order_id] ?? null;
            if ($apiData && isset($apiData['status'])) {
                $order->api_status  = strtolower($apiData['status']);
                $order->api_remains = $apiData['remains'] ?? $order->remains;
                $order->api_start   = $apiData['start_count'] ?? $order->start_count;
            } else {
                // Fallback to DB value
                $order->api_status  = $order->status;
                $order->api_remains = $order->remains;
                $order->api_start   = $order->start_count;
            }
        }

        $stats = [
            'total'      => Order::count(),
            'pending'    => Order::where('status', 'pending')->count(),
            'processing' => Order::whereIn('status', ['processing', 'inprogress', 'in progress'])->count(),
            'completed'  => Order::where('status', 'completed')->count(),
            'partial'    => Order::where('status', 'partial')->count(),
            'failed'     => Order::whereIn('status', ['failed', 'canceled', 'cancelled'])->count(),
        ];

        return view('settings.orders', compact('orders', 'stats'));
    }

    /**
     * Show tickets page (placeholder).
     */
    public function tickets()
    {
        return view('settings.tickets');
    }

    /**
     * Show users currently online (active within last 5 minutes).
     */
    public function onlineUsers()
    {
        // Online = last seen within 5 minutes
        $onlineUsers = User::whereNotNull('last_seen_at')
            ->where('last_seen_at', '>=', now()->subMinutes(5))
            ->orderByDesc('last_seen_at')
            ->get();

        // Recent activity: active in last hour
        $recentUsers = User::whereNotNull('last_seen_at')
            ->where('last_seen_at', '>=', now()->subHour())
            ->where('last_seen_at', '<', now()->subMinutes(5))
            ->orderByDesc('last_seen_at')
            ->get();

        return view('settings.online-users', compact('onlineUsers', 'recentUsers'));
    }

    /**
     * Toggle user API access.
     */
    public function toggleAllowApiKey($id)
    {
        $user = User::findOrFail($id);

        // Prevent toggling for self if needed, though API access might be fine for admin self

        $user->allow_api_key = !$user->allow_api_key;
        $user->save();

        $status = $user->allow_api_key ? 'مفعل' : 'معطل';
        return back()->with('success', "تم تغيير حالة الوصول للـ API للمستخدم {$user->name} إلى {$status}.");
    }
}
