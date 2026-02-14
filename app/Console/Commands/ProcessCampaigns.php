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
    protected $token;

    /**
     * Max seconds this command should run within one cron cycle.
     * Set to 55 to leave a 5-second safety margin before the next cron tick.
     */
    protected $maxRunTime = 55;

    public function handle(): int
    {
        // Fetch API Token from Settings
        $this->token = \App\Models\Setting::where('key', 'admin_whatsapp_access_token')->value('value');

        if (!$this->token) {
            $this->error('Admin WhatsApp Access Token is missing in Settings.');
            Log::error('ProcessCampaigns: Access Token missing.');
            return 1;
        }

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
        $startTime = time();

        while (time() - $startTime < $this->maxRunTime) {
            // Refresh campaign from DB (status may have changed)
            $campaign->refresh();

            if ($campaign->status !== 'sending') {
                $this->info("Campaign #{$campaign->id} is no longer 'sending'. Stopping.");
                return;
            }

            // --- Batch Sleep Check ---
            if ($campaign->batch_size > 0 && $campaign->batch_sent_count >= $campaign->batch_size) {
                $campaign->update([
                    'last_sent_at' => now()->addMinutes($campaign->batch_sleep),
                    'batch_sent_count' => 0,
                ]);
                $this->info("Campaign #{$campaign->id}: Batch limit reached. Sleeping {$campaign->batch_sleep} min.");
                return; // Exit — next cron runs will skip until last_sent_at passes
            }

            // --- Delay Check ---
            if ($campaign->last_sent_at && now()->lt($campaign->last_sent_at)) {
                $waitSeconds = (int) now()->diffInSeconds($campaign->last_sent_at, false);

                if ($waitSeconds <= 0) {
                    // Time has already passed, proceed
                } elseif (time() - $startTime + $waitSeconds > $this->maxRunTime) {
                    // Not enough time left in this run, let next cron handle it
                    $this->info("Campaign #{$campaign->id}: Delay {$waitSeconds}s exceeds remaining time. Deferring.");
                    return;
                } else {
                    // We have time — sleep and wait
                    $this->info("Campaign #{$campaign->id}: Waiting {$waitSeconds}s...");
                    sleep($waitSeconds);
                }
            }

            // --- Fetch Next Pending Log ---
            $log = WhatsappCampaignLog::where('whatsapp_campaign_id', $campaign->id)
                ->where('status', 'pending')
                ->first();

            if (!$log) {
                $campaign->update(['status' => 'completed']);
                $this->info("Campaign #{$campaign->id} completed — no more pending messages.");
                return;
            }

            // --- Send Message ---
            $this->sendMessage($campaign, $log);

            // --- Set Next Delay ---
            $delay = rand($campaign->min_delay, $campaign->max_delay);
            $updateData = [
                'last_sent_at' => now()->addSeconds($delay),
            ];

            // Increment batch counter if batch feature is enabled
            if ($campaign->batch_size > 0) {
                $updateData['batch_sent_count'] = $campaign->batch_sent_count + 1;
            }

            $campaign->update($updateData);

            // If delay exceeds remaining time, exit and let next cron handle it
            $elapsed = time() - $startTime;
            if ($delay > ($this->maxRunTime - $elapsed)) {
                $this->info("Campaign #{$campaign->id}: Next delay {$delay}s. Deferring to next cron.");
                return;
            }

            // Sleep for the delay within this run
            $this->info("Campaign #{$campaign->id}: Sent to {$log->phone_number}. Sleeping {$delay}s...");
            sleep($delay);
        }

        $this->info("Time limit reached. Exiting.");
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

            // Select random message
            $text = is_array($messages) ? $messages[array_rand($messages)] : $messages;

            // Replace Placeholders
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

            // Auto-format Egyptian numbers (01xxxxxxxxx -> 201xxxxxxxxx)
            if (strlen($number) === 11 && str_starts_with($number, '01')) {
                $number = '2' . $number;
            }

            // Verify number is not empty
            if (empty($number)) {
                throw new \Exception("Invalid phone number: {$log->phone_number}");
            }

            $payload = [
                'number' => $number,
                'instance_id' => $campaign->instance_id,
                'access_token' => $this->token,
            ];

            // Determine Type (Text vs Media)
            if ($campaign->media_path) {
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

            // Send Request
            $response = Http::timeout(60)->post($this->baseUrl . '/send', $payload);
            $resData = $response->json();

            // Handle Response
            if ($response->successful() && ($resData['status'] ?? '') === 'success') {
                $log->update([
                    'status' => 'sent',
                    'message_id' => $resData['data']['key']['id'] ?? $resData['message_id'] ?? null,
                ]);
                $campaign->increment('sent_count');
                $this->info("✓ Sent to {$number}");
            } else {
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
