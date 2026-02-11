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
        // last_sent_at stores the NEXT allowed send time (not the actual last sent time)
        // This ensures the random delay is calculated ONCE and stays fixed
        if ($campaign->last_sent_at && now()->lt($campaign->last_sent_at)) {
            $remaining = (int) now()->diffInSeconds($campaign->last_sent_at);
            $this->info("Campaign #{$campaign->id}: waiting {$remaining}s before next message.");
            return;
        }

        // Fetch next pending log
        $log = WhatsappCampaignLog::where('whatsapp_campaign_id', $campaign->id)
            ->where('status', 'pending')
            ->first();

        if (!$log) {
            $campaign->update(['status' => 'completed']);
            $this->info("Campaign #{$campaign->id}: completed!");
            Log::info("Campaign #{$campaign->id} completed.");
            return;
        }

        // Select random message
        $messages = $campaign->message;
        $text = is_array($messages) ? $messages[array_rand($messages)] : $messages;

        // Clean number
        $number = preg_replace('/[^0-9]/', '', $log->phone_number);

        try {
            $payload = [
                'number' => $number,
                'type' => 'text',
                'message' => $text,
                'instance_id' => $campaign->instance_id,
                'access_token' => $this->token,
            ];

            $response = Http::timeout(60)->post($this->baseUrl . '/send', $payload);
            $resData = $response->json();

            if ($response->successful() && ($resData['status'] ?? '') === 'success') {
                $log->update([
                    'status' => 'sent',
                    'message_id' => $resData['data']['key']['id'] ?? $resData['message_id'] ?? null,
                ]);
                $campaign->increment('sent_count');

                // Calculate delay ONCE and store the NEXT allowed send time
                $delay = rand($campaign->min_delay, $campaign->max_delay);
                $campaign->update(['last_sent_at' => now()->addSeconds($delay)]);

                $this->info("Campaign #{$campaign->id}: sent to {$number} ✓ (next in {$delay}s)");
                Log::info("Campaign #{$campaign->id}: sent to {$number}, next in {$delay}s");
            } else {
                throw new \Exception($resData['message'] ?? 'Unknown API Error');
            }
        } catch (\Exception $e) {
            $log->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
            $campaign->increment('failed_count');

            // Even on fail, set next send time to avoid rapid retries
            $delay = rand($campaign->min_delay, $campaign->max_delay);
            $campaign->update(['last_sent_at' => now()->addSeconds($delay)]);

            $this->error("Campaign #{$campaign->id}: failed to {$number} - {$e->getMessage()}");
            Log::error("Campaign #{$campaign->id}: failed to {$number} - {$e->getMessage()}");
        }

        // Check remaining
        $remaining = WhatsappCampaignLog::where('whatsapp_campaign_id', $campaign->id)
            ->where('status', 'pending')
            ->count();

        if ($remaining === 0) {
            $campaign->update(['status' => 'completed']);
            $this->info("Campaign #{$campaign->id}: all messages processed, completed!");
        } else {
            $this->info("Campaign #{$campaign->id}: {$remaining} messages remaining.");
        }
    }
}
