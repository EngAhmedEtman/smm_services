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

        return view('dashboard', compact('totalMessagesSent', 'whatsappConnectedCount'));
    }
}
