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
        // Check if enough time has passed since last message
        if ($campaign->last_sent_at) {
            $delay = rand($campaign->min_delay, $campaign->max_delay);
            $nextSendAt = Carbon::parse($campaign->last_sent_at)->addSeconds($delay);

            if (now()->lt($nextSendAt)) {
                $remaining = now()->diffInSeconds($nextSendAt);
                $this->info("Campaign #{$campaign->id}: waiting {$remaining}s before next message.");
                return; // Not time yet
            }
        }

        // Fetch next pending log
        $log = WhatsappCampaignLog::where('whatsapp_campaign_id', $campaign->id)
            ->where('status', 'pending')
            ->first();

        if (!$log) {
            // All messages processed
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
                $campaign->update(['last_sent_at' => now()]);

                $this->info("Campaign #{$campaign->id}: sent to {$number} ✓");
                Log::info("Campaign #{$campaign->id}: sent to {$number}");
            } else {
                throw new \Exception($resData['message'] ?? 'Unknown API Error');
            }
        } catch (\Exception $e) {
            $log->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
            $campaign->increment('failed_count');
            $campaign->update(['last_sent_at' => now()]);

            $this->error("Campaign #{$campaign->id}: failed to {$number} - {$e->getMessage()}");
            Log::error("Campaign #{$campaign->id}: failed to {$number} - {$e->getMessage()}");
        }

        // Check if all done
        $remaining = WhatsappCampaignLog::where('whatsapp_campaign_id', $campaign->id)
            ->where('status', 'pending')
            ->count();

        if ($remaining === 0) {
            $campaign->update(['status' => 'completed']);
            $this->info("Campaign #{$campaign->id}: all messages processed, completed!");
            Log::info("Campaign #{$campaign->id} completed.");
        } else {
            $this->info("Campaign #{$campaign->id}: {$remaining} messages remaining.");
        }
    }
}
