<?php

namespace App\Http\Controllers;

use App\Models\WhatsappCampaign;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        # Use the column for total messages sent as it represents the deducted quota
        $totalMessagesSent = $user->total_messages_sent;

        $whatsappConnectedCount = \App\Models\Whatsapp::where('user_id', $user->id)->where('status', 'connected')->count();

        // Get Package Subscription Info
        $apiClient = \App\Models\ApiClient::where('user_id', $user->id)->first();
        $subscriptionData = null;

        if ($apiClient && $apiClient->hasActivePackage()) {
            $package = \App\Models\WhatsAppPackage::where('name', $apiClient->package_name)->first();

            $subscriptionData = [
                'package_name' => $apiClient->package_name,
                'balance' => $apiClient->balance,
                'total_messages' => $package ? $package->message_limit : 0,
                'usage_percentage' => $package && $package->message_limit > 0
                    ? round((($package->message_limit - $apiClient->balance) / $package->message_limit) * 100, 1)
                    : 0,
                'days_left' => $apiClient->expire_at ? now()->diffInDays($apiClient->expire_at, false) : 0,
                'expire_at' => $apiClient->expire_at,
                'status' => $apiClient->package_status,
            ];
        }

        return view('dashboard', compact('totalMessagesSent', 'whatsappConnectedCount', 'subscriptionData'));
    }
}
