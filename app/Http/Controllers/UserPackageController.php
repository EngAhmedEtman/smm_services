<?php

namespace App\Http\Controllers;

use App\Models\WhatsAppPackage;
use App\Models\ApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserPackageController extends Controller
{
    // Public showcase - no authentication required
    public function showcase()
    {
        $packages = WhatsAppPackage::active()->orderBy('price')->get();
        return view('packages.showcase', compact('packages'));
    }

    public function index()
    {
        $packages = WhatsAppPackage::active()->orderBy('price')->get();
        $apiClient = auth()->check() ? ApiClient::where('user_id', auth()->id())->first() : null;

        return view('packages.index', compact('packages', 'apiClient'));
    }

    public function subscribe(Request $request)
    {
        $package = WhatsAppPackage::findOrFail($request->package_id);
        $user = auth()->user();

        // التحقق من الرصيد
        if ($user->balance < $package->price) {
            return back()->with('error', 'رصيدك غير كافي. يرجى شحن حسابك أولاً.');
        }

        // جلب أو إنشاء ApiClient
        $apiClient = ApiClient::firstOrCreate(
            ['user_id' => $user->id],
            ['api_key' => Str::random(40), 'balance' => 0, 'status' => 1]
        );

        // Rollover: إضافة الرسائل المتبقية إذا جدد مبكراً
        $rolloverMessages = 0;
        if ($apiClient->hasActivePackage() && $apiClient->balance > 0) {
            $rolloverMessages = $apiClient->balance;
        }

        // تحديث الاشتراك
        $apiClient->update([
            'package_name' => $package->name,
            'package_status' => 'active',
            'balance' => $package->message_limit + $rolloverMessages,
            'expire_at' => now()->addDays($package->duration_days),
        ]);

        // خصم من رصيد اليوزر
        $user->decrement('balance', $package->price);

        $message = "تم الاشتراك في {$package->name} بنجاح!";
        if ($rolloverMessages > 0) {
            $message .= " تم إضافة {$rolloverMessages} رسالة متبقية من باقتك السابقة.";
        }

        return back()->with('success', $message);
    }
}
