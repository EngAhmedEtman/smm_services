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
    public function users()
    {
        $users = User::latest()->get();
        return view('settings.users', compact('users'));
    }

    /**
     * Show tickets page (placeholder).
     */
    public function tickets()
    {
        return view('settings.tickets');
    }
}
