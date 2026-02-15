<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InstanceController extends Controller
{
    private $baseUrl = 'https://wolfixbot.com/api';
    private $accessToken;

    public function __construct()
    {
        // يُفضل سحب التوكن من config/services.php
        $this->accessToken = config('services.whatsapp.token'); 
    }


    public function test()
    {
        return response()->json([
            'success' => true,
            'message' => 'API Key is valid.'
        ]);
    }
    

    // 1. إنشاء Instance جديد
    public function createInstance()
    {
        $response = Http::post("{$this->baseUrl}/create_instance", [
            'access_token' => $this->accessToken,
        ]);

        return response()->json($response->json());
    }

    // 2. جلب كود الـ QR
    public function getQrCode(Request $request)
    {
        $request->validate(['instance_id' => 'required|string']);

        $response = Http::post("{$this->baseUrl}/get_qrcode", [
            'instance_id'  => $request->instance_id,
            'access_token' => $this->accessToken,
        ]);

        return response()->json($response->json());
    }

    // 3. إعداد الـ Webhook
    public function setWebhook(Request $request)
    {
        $request->validate([
            'instance_id' => 'required|string',
            'webhook_url' => 'required|url',
            'enable'      => 'required|boolean'
        ]);

        $response = Http::post("{$this->baseUrl}/set_webhook", [
            'webhook_url'  => $request->webhook_url,
            'enable'       => $request->enable ? 'true' : 'false',
            'instance_id'  => $request->instance_id,
            'access_token' => $this->accessToken,
        ]);

        return response()->json($response->json());
    }

    // 4. عمل Reboot للـ Instance
    public function rebootInstance(Request $request)
    {
        $request->validate(['instance_id' => 'required|string']);

        $response = Http::post("{$this->baseUrl}/reboot", [
            'instance_id'  => $request->instance_id,
            'access_token' => $this->accessToken,
        ]);

        return response()->json($response->json());
    }

    // 5. عمل Reset للـ Instance (مسح الداتا وتغيير الـ ID)
    public function resetInstance(Request $request)
    {
        $request->validate(['instance_id' => 'required|string']);

        $response = Http::post("{$this->baseUrl}/reset_instance", [
            'instance_id'  => $request->instance_id,
            'access_token' => $this->accessToken,
        ]);

        return response()->json($response->json());
    }

    // 6. إعادة الاتصال (Reconnect)
    public function reconnectInstance(Request $request)
    {
        $request->validate(['instance_id' => 'required|string']);

        $response = Http::post("{$this->baseUrl}/reconnect", [
            'instance_id'  => $request->instance_id,
            'access_token' => $this->accessToken,
        ]);

        return response()->json($response->json());
    }
}