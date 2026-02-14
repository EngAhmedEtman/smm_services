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
    protected $token = '6983b5e6a0994'; // Primary token for App Instances

    /**
     * Max seconds this command should run within one cron cycle.
     */
    protected $maxRunTime = 55;

    public function handle(): int
    {
        $campaigns = WhatsappCampaign::where('status', 'sending')->get();

        if ($campaigns->isEmpty()) {
            return 0;
        }

        foreach ($campaigns as $campaign) {
            $this->processCampaign($campaign);
        }

        return 0;
    }

    protected function processCampaign(WhatsappCampaign $campaign): void
    {
        $startTime = time();

        while (time() - $startTime < $this->maxRunTime) {
            $campaign->refresh();

            if ($campaign->status !== 'sending') {
                return;
            }

            // --- Batch Sleep Check ---
            if ($campaign->batch_size > 0 && $campaign->batch_sent_count >= $campaign->batch_size) {
                $campaign->update([
                    'last_sent_at' => now()->addMinutes($campaign->batch_sleep),
                    'batch_sent_count' => 0,
                ]);
                return;
            }

            // --- Delay Check ---
            if ($campaign->last_sent_at && now()->lt($campaign->last_sent_at)) {
                $waitSeconds = (int) now()->diffInSeconds($campaign->last_sent_at, false);

                if ($waitSeconds <= 0) {
                    // proceed
                } elseif (time() - $startTime + $waitSeconds > $this->maxRunTime) {
                    return;
                } else {
                    sleep($waitSeconds);
                }
            }

            // --- Fetch Next Log ---
            $log = WhatsappCampaignLog::where('whatsapp_campaign_id', $campaign->id)
                ->where('status', 'pending')
                ->first();

            if (!$log) {
                $campaign->update(['status' => 'completed']);
                return;
            }

            // --- Send Message ---
            $this->sendMessage($campaign, $log);

            // --- Set Next Delay ---
            $delay = rand($campaign->min_delay, $campaign->max_delay);
            $updateData = ['last_sent_at' => now()->addSeconds($delay)];

            if ($campaign->batch_size > 0) {
                $updateData['batch_sent_count'] = $campaign->batch_sent_count + 1;
            }

            $campaign->update($updateData);

            if ($delay > ($this->maxRunTime - (time() - $startTime))) {
                return;
            }

            sleep($delay);
        }
    }

    protected function sendMessage(WhatsappCampaign $campaign, WhatsappCampaignLog $log): void
    {
        try {
            // Prepare Message Content
            $messages = $campaign->message;
            if (is_string($messages)) {
                $decoded = json_decode($messages, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $messages = $decoded;
                }
            }

            $text = is_array($messages) ? $messages[array_rand($messages)] : $messages;

            // Placeholders
            if (str_contains($text, '{{random}}')) {
                $randomText = \App\Models\WhatsappRandomText::inRandomOrder()->value('text') ?? '';
                $text = str_replace('{{random}}', $randomText, $text);
            }
            if (str_contains($text, '{{welcome}}')) {
                $welcomeText = \App\Models\WhatsappWelcomeText::inRandomOrder()->value('text') ?? '';
                $text = str_replace('{{welcome}}', $welcomeText, $text);
            }
            $text = str_replace('{{date}}', now()->toDateString(), $text);

            // Prepare Payload
            $number = preg_replace('/[^0-9]/', '', $log->phone_number);

            // Safe formatting for Egyptian numbers
            if (strlen($number) === 11 && str_starts_with($number, '01')) {
                $number = '2' . $number;
            }

            $payload = [
                'number' => $number,
                'instance_id' => $campaign->instance_id,
                'access_token' => $this->token,
            ];

            // Determine Type
            // FIX: Check if file exists to avoid sending broken media links
            $hasMedia = !empty($campaign->media_path) && \Illuminate\Support\Facades\Storage::disk('public')->exists($campaign->media_path);

            if ($hasMedia) {
                $payload['type'] = 'media';
                $payload['message'] = $text;
                $payload['media_url'] = asset('storage/' . $campaign->media_path);

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

            // LOG THE PAYLOAD TO SEE WHAT IS WRONG
            Log::info("Campaign Sending Payload: " . json_encode($payload));

            // Send
            $response = Http::timeout(60)->post($this->baseUrl . '/send', $payload);
            $resData = $response->json();

            if ($response->successful() && ($resData['status'] ?? '') === 'success') {
                $log->update([
                    'status' => 'sent',
                    'message_id' => $resData['data']['key']['id'] ?? $resData['message_id'] ?? null,
                ]);
                $campaign->increment('sent_count');
                $this->info("✓ Sent to {$number}");
            } else {
                // Log failure for external debugging
                $errorDetails = json_encode($resData);
                Log::error("Campaign Failed | Inst: {$campaign->instance_id} | Token: {$this->token} | Resp: {$errorDetails}");
                throw new \Exception($resData['message'] ?? 'API Error');
            }
        } catch (\Exception $e) {
            $log->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
            $campaign->increment('failed_count');
            $this->error("✗ Failed {$log->phone_number}: " . $e->getMessage());
        }
    }
}
