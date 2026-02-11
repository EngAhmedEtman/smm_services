<?php

namespace App\Jobs;

use App\Models\WhatsappCampaign;
use App\Models\WhatsappCampaignLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendCampaignMessages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $campaignId;
    protected $baseUrl = 'https://wolfixbot.com/api';
    protected $token = '6983b5e6a0994';

    /**
     * Create a new job instance.
     */
    public function __construct($campaignId)
    {
        $this->campaignId = $campaignId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $campaign = WhatsappCampaign::find($this->campaignId);

        if (!$campaign) {
            Log::error("Campaign not found: " . $this->campaignId);
            return;
        }

        // Check if campaign is paused or completed
        if ($campaign->status == 'paused' || $campaign->status == 'completed' || $campaign->status == 'pending') {
            return; // Stop processing
        }

        // Fetch ONE next pending log
        $log = WhatsappCampaignLog::where('whatsapp_campaign_id', $campaign->id)
            ->where('status', 'pending')
            ->first();

        if (!$log) {
            $campaign->update(['status' => 'completed']);
            return; // Done
        }

        // Select Random Message
        $messages = $campaign->message; // Array
        $text = is_array($messages) ? $messages[array_rand($messages)] : $messages;

        // Clean Number
        $number = preg_replace('/[^0-9]/', '', $log->phone_number);

        try {
            // Send API Request
            $payload = [
                'number' => $number,
                'type' => 'text',
                'message' => $text,
                'instance_id' => $campaign->instance_id,
                'access_token' => $this->token,
            ];

            $response = Http::timeout(60)->post($this->baseUrl . '/send', $payload);
            $resData = $response->json();

            if ($response->successful() && !isset($resData['error'])) {
                // Success
                $log->update([
                    'status' => 'sent',
                    'message_id' => $resData['message_id'] ?? $resData['id'] ?? null,
                ]);
                $campaign->increment('sent_count');
            } else {
                // API Error
                throw new \Exception($resData['message'] ?? 'Unknown API Error');
            }
        } catch (\Exception $e) {
            // Failed
            $log->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
            $campaign->increment('failed_count');
        }

        // Check if more pending messages exist
        $remaining = WhatsappCampaignLog::where('whatsapp_campaign_id', $campaign->id)
            ->where('status', 'pending')
            ->exists();

        if ($remaining) {
            // Dispatch NEXT Job with Delay
            $delay = rand($campaign->min_delay, $campaign->max_delay);

            // Re-dispatch itself
            self::dispatch($this->campaignId)->delay(now()->addSeconds($delay));
        } else {
            // All done (double check)
            $campaign->update(['status' => 'completed']);
        }
    }
}
