<?php

namespace App\Http\Controllers;

use App\Models\WhatsappCampaign;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMessagesSent = WhatsappCampaign::where('user_id', auth()->id())->sum('sent_count');

        return view('dashboard', compact('totalMessagesSent'));
    }
}
