<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsappService
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = config('services.whatsapp.url');
        $this->token   = config('services.whatsapp.token');
    }

    public function createInstance()
    {
        return Http::post($this->baseUrl.'/create_instance', [
            'access_token' => $this->token
        ])->json();
    }

    public function getQrCode($instanceId)
    {
        return Http::post($this->baseUrl.'/get_qrcode', [
            'instance_id'  => $instanceId,
            'access_token' => $this->token
        ])->json();
    }


    public function rebootInstance($instanceId)
    {
        return Http::post($this->baseUrl.'/reboot', [
            'instance_id'  => $instanceId,
            'access_token' => $this->token
        ])->json();
    }

    public function resetInstance($instanceId)
    {
        return Http::post($this->baseUrl.'/reset_instance', [
            'instance_id'  => $instanceId,
            'access_token' => $this->token
        ])->json();
    }


    public function sendText($instanceId, $number, $message)
    {
        return Http::post($this->baseUrl.'/send', [
            'number'       => $number,
            'type'         => 'text',
            'message'      => $message,
            'instance_id'  => $instanceId,
            'access_token' => $this->token
        ])->json();
    }
}
