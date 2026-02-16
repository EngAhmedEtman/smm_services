<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Recharge;
use App\Models\User;
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
     * Show tickets page (placeholder).
     */
    public function tickets()
    {
        return view('settings.tickets');
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
