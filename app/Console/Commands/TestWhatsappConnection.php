<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestWhatsappConnection extends Command
{
    protected $signature = 'whatsapp:test {phone}';
    protected $description = 'Test WhatsApp Connection with a simple text message';

    public function handle()
    {
        $phone = $this->argument('phone');
        $this->info("Testing connection to: $phone");

        // Hardcoded Credentials (MATCHING ProcessCampaigns.php)
        $instanceId = '698A9E6ACC706'; // The Admin Instance ID from logs
        $token = '6983b5e6a0994';       // The Hardcoded Token

        // Format Number (Egyptian 20 prefix)
        $number = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($number) === 11 && str_starts_with($number, '01')) {
            $number = '2' . $number;
        }

        $url = "https://wolfixbot.com/api/send";
        $payload = [
            'number' => $number,
            'type' => 'text',
            'message' => "🔔 Test Message from Command Line\nInstance: $instanceId",
            'instance_id' => $instanceId,
            'access_token' => $token
        ];

        $this->info("Sending Payload to $url...");
        $this->info(json_encode($payload, JSON_PRETTY_PRINT));

        try {
            $response = Http::timeout(30)->post($url, $payload);

            $this->info("Response Status: " . $response->status());
            $this->info("Response Body: " . $response->body());

            if ($response->successful()) {
                $this->info("✅ SUCCESS! Message sent.");
            } else {
                $this->error("❌ FAILED! API Error.");
            }
        } catch (\Exception $e) {
            $this->error("❌ EXCEPTION: " . $e->getMessage());
        }
    }
}
