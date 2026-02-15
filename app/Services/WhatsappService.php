<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    protected $apiUrl;
    protected $token;

    public function __construct()
    {


        $this->apiUrl = config('services.whatsapp.url');
        $this->token = config('services.whatsapp.token');
    }

    /**
     * إرسال رسالة نصية
     */
    public function sendText($instanceId, $number, $message)
    {
        try {
            $response = Http::post("{$this->apiUrl}/send", [
                'instance_id' => $instanceId,
                'access_token' => $this->token, // التوكن الأصلي بتاعك مخفي هنا!
                'number' => $number,
                'message' => $message,
            ]);

            return $response->json();
            
        } catch (\Exception $e) {
            Log::error('Wolfixbot Send Text Error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Internal API Error'];
        }
    }

    // هنضيف هنا باقي الدوال زي sendMedia و createInstance وهكذا...
}