<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InstanceController extends Controller
{
    private $baseUrl;
    private $accessToken;
    private $webhookUrl;

    public function __construct()
    {
        // يُفضل سحب التوكن من config/services.php
        $this->baseUrl = config('services.whatsapp.url');
        $this->accessToken = config('services.whatsapp.token');
        $this->webhookUrl = config('services.whatsapp.webhook_url');
    }


    public function test()
    {
        return response()->json([
            'success' => true,
            'message' => 'API Key is valid.'
        ]);
    }


    // 1. إنشاء Instance جديد
    public function create_instance()
    {

        $Response = Http::get(
            $this->baseUrl . '/create_instance',
            ['access_token' => $this->accessToken]
        )->json();

        return response()->json($Response);
    }


    
    // 2. جلب كود الـ QR
    public function getQrCode(Request $request)
    {
        $instanceId = $request->instance_id;

        // 2️⃣ Get QR Code
        return    $qrResponse = Http::get(
            $this->baseUrl . '/get_qrcode',
            [
                'instance_id' => $instanceId,
                'access_token' => $this->accessToken
            ]
        )->json();
    }



    // 3. إعداد الـ Webhook
    public function setWebhook(Request $request)
    {
        $request->validate([
            'instance_id' => 'required|string',
            'enable'      => 'required|boolean'
        ]);

        $response = Http::get("{$this->baseUrl}/set_webhook", [
            'webhook_url'  => $this->webhookUrl,
            'enable'       => $request->enable ? 'true' : 'false',
            'instance_id'  => $request->instance_id,
            'access_token' => $this->accessToken,
        ]);

        return response()->json($response->json());
    }

    // 4. عمل Reboot للـ Instance
    public function rebootInstance(Request $request)
    {

        $response = Http::get("{$this->baseUrl}/reboot", [
            'instance_id'  => $request->instance_id,
            'access_token' => $this->accessToken,
        ]);

        return response()->json($response->json());
    }



    // 5. عمل Reset للـ Instance (مسح الداتا وتغيير الـ ID)
    public function resetInstance(Request $request)
    {

        $instanceId = trim($request->instance_id);

        $response = Http::get("{$this->baseUrl}/reset_instance", [
            'instance_id'  => $instanceId,
            'access_token' => $this->accessToken
        ]);

        return response()->json($response->json());
    }



    
    // 6. إعادة الاتصال (Reconnect)
    public function reconnectInstance(Request $request)
    {
        $request->validate(['instance_id' => 'required|string']);

        $response = Http::get("{$this->baseUrl}/reconnect", [
            'instance_id'  => $request->instance_id,
            'access_token' => $this->accessToken,
        ]);

        return response()->json($response->json());
    }





    
}
