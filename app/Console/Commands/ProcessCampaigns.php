<?php

namespace App\Console\Commands;

use App\Models\WhatsappCampaign;
use App\Models\WhatsappCampaignLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ProcessCampaigns extends Command
{
    protected $signature = 'campaign:process';
    protected $description = 'Process active WhatsApp campaigns and send pending messages';

    protected $baseUrl = 'https://wolfixbot.com/api';
    protected $token = '6983b5e6a0994';

    public function handle(): int
    {
        $campaigns = WhatsappCampaign::where('status', 'sending')->get();

        if ($campaigns->isEmpty()) {
            $this->info('No active campaigns.');
            return 0;
        }

        foreach ($campaigns as $campaign) {
            $this->processCampaign($campaign);
        }

        return 0;
    }

    protected function processCampaign(WhatsappCampaign $campaign): void
    {
        // 1. Check delay
        if ($campaign->last_sent_at && now()->lt($campaign->last_sent_at)) {
            return;
        }

        // 2. Fetch next pending log
        $log = WhatsappCampaignLog::where('whatsapp_campaign_id', $campaign->id)
            ->where('status', 'pending')
            ->first();

        // 3. Mark completed if no logs
        if (!$log) {
            $campaign->update(['status' => 'completed']);
            Log::info("Campaign #{$campaign->id} completed.");
            return;
        }

        try {
            // 4. Prepare Message Content
            $messages = $campaign->message;
            // Handle JSON decoding if it's a string
            if (is_string($messages)) {
                $decoded = json_decode($messages, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $messages = $decoded;
                }
            }

            // Select random message
            $text = is_array($messages) ? $messages[array_rand($messages)] : $messages;

            // 5. Replace Placeholders
            // {{random}}
            if (str_contains($text, '{{random}}')) {
                $randomText = \App\Models\WhatsappRandomText::inRandomOrder()->value('text') ?? '';
                $text = str_replace('{{random}}', $randomText, $text);
            }

            // {{welcome}}
            if (str_contains($text, '{{welcome}}')) {
                $welcomeText = \App\Models\WhatsappWelcomeText::inRandomOrder()->value('text') ?? '';
                $text = str_replace('{{welcome}}', $welcomeText, $text);
            }

            // {{date}}
            $text = str_replace('{{date}}', now()->toDateString(), $text);

            // 6. Prepare Payload
            $number = preg_replace('/[^0-9]/', '', $log->phone_number);
            $payload = [
                'number' => $number,
                'instance_id' => $campaign->instance_id,
                'access_token' => $this->token,
            ];

            // 7. Determine Type (Text vs Media)
            if ($campaign->media_path) {
                $payload['type'] = 'media';
                $payload['message'] = $text; // Caption
                $payload['media_url'] = asset('storage/' . $campaign->media_path);

                // Determine media type (image/document) based on extension
                $extension = pathinfo($campaign->media_path, PATHINFO_EXTENSION);
                if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif'])) {
                    $payload['media_type'] = 'image';
                } else {
                    $payload['media_type'] = 'document';
                    $payload['filename'] = basename($campaign->media_path);
                }
            } else {
                $payload['type'] = 'text';
                $payload['message'] = $text;
            }

            // 8. Send Request
            $response = Http::timeout(60)->post($this->baseUrl . '/send', $payload);
            $resData = $response->json();

            // 9. Handle Response
            if ($response->successful() && ($resData['status'] ?? '') === 'success') {
                $log->update([
                    'status' => 'sent',
                    'message_id' => $resData['data']['key']['id'] ?? $resData['message_id'] ?? null,
                ]);
                $campaign->increment('sent_count');

                // Set next delay
                $delay = rand($campaign->min_delay, $campaign->max_delay);
                $campaign->update(['last_sent_at' => now()->addSeconds($delay)]);

                $this->info("Sent to {$number} (Next in {$delay}s)");
            } else {
                throw new \Exception($resData['message'] ?? 'API Error');
            }
        } catch (\Exception $e) {
            $log->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
            $campaign->increment('failed_count');

            // Set delay purely to prevent hammering
            $delay = rand($campaign->min_delay, $campaign->max_delay);
            $campaign->update(['last_sent_at' => now()->addSeconds($delay)]);

            $this->error("Failed {$number}: " . $e->getMessage());
        }
    }
}
