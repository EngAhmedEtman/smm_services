<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdminNotificationService
{
    protected static $baseUrl = 'https://wolfixbot.com/api';

    /**
     * Send notification to admin when a new recharge is created.
     *
     * @param \App\Models\Recharge $recharge
     * @return void
     */
    public static function notifyNewRecharge($recharge)
    {
        try {
            Log::info('AdminNotification: Starting for Recharge #' . $recharge->id);

            // Fetch credentials from DB
            $instanceId = Setting::where('key', 'admin_whatsapp_instance_id')->value('value');
            $accessToken = Setting::where('key', 'admin_whatsapp_access_token')->value('value');
            $adminPhone = Setting::where('key', 'admin_receiver_number')->value('value');

            // If settings are missing, skip notification silently
            if (!$instanceId || !$accessToken || !$adminPhone) {
                Log::warning('AdminNotification: Settings missing.');
                return;
            }

            $user = $recharge->user;
            $number = preg_replace('/[^0-9]/', '', $adminPhone);

            // Format text message
            $message = "🔔 *إشعار إيداع جديد*\n\n" .
                "👤 العميل: {$user->name}\n" .
                "📧 البريد: {$user->email}\n" .
                "💰 المبلغ: {$recharge->amount} جنيه\n" .
                "🆔 رقم المعاملة: #{$recharge->id}\n" .
                "📅 الوقت: " . now()->format('Y-m-d h:i A');

            // Step 1: Send TEXT notification (guaranteed)
            $textPayload = [
                'number' => $number,
                'type' => 'text',
                'message' => $message,
                'instance_id' => $instanceId,
                'access_token' => $accessToken
            ];

            $textResponse = Http::timeout(15)->post(self::$baseUrl . '/send', $textPayload);
            Log::info('AdminNotification: Text sent [' . $textResponse->status() . ']: ' . $textResponse->body());

            // Step 2: Send MEDIA (proof image) as a separate message
            if ($recharge->proof_image) {
                $imageUrl = url('file/' . $recharge->proof_image);

                Log::info('AdminNotification: Sending media: ' . $imageUrl);


                $mediaPayload = [
                    'number' => $number,
                    'type' => 'media',
                    'message' => "📎 صورة إثبات التحويل - طلب #{$recharge->id}",
                    'media_url' => $imageUrl,
                    'instance_id' => $instanceId,
                    'access_token' => $accessToken
                ];

                $mediaResponse = Http::timeout(20)->post(self::$baseUrl . '/send', $mediaPayload);
                Log::info('AdminNotification: Media sent [' . $mediaResponse->status() . ']: ' . $mediaResponse->body());
            }
        } catch (\Exception $e) {
            // Log error but don't break the user flow
            Log::error("Admin Notification Error: " . $e->getMessage());
        }
    }

    public static function notifyNewRechargeApproved($recharge)
    {
        try {
            Log::info('AdminNotification: Starting for Recharge #' . $recharge->id);

            // Fetch credentials from DB
            $instanceId = Setting::where('key', 'admin_whatsapp_instance_id')->value('value');
            $accessToken = Setting::where('key', 'admin_whatsapp_access_token')->value('value');
            $adminPhone = Setting::where('key', 'admin_receiver_number')->value('value');

            // If settings are missing, skip notification silently
            if (!$instanceId || !$accessToken || !$adminPhone) {
                Log::warning('AdminNotification: Settings missing.');
                return;
            }

            $user = $recharge->user;
            // Reverted to correct user relation
            $number = preg_replace('/[^0-9]/', '', $user->phone);

            // Auto-format Egyptian numbers (01xxxxxxxxx -> 201xxxxxxxxx)
            if (strlen($number) === 11 && str_starts_with($number, '01')) {
                $number = '2' . $number;
            }

            Log::info("AdminNotification: Processing for UserID: {$user->id}, RawPhone: {$user->phone}, CleanedPhone: {$number}");

            if (empty($number)) {
                Log::warning("AdminNotification: User {$user->id} has no valid phone number. Skipping notification.");
                return;
            }

            // Format text message
            $message = "🔔 *تم قبول إيداع جديد* " .


                "تم شحن حسابك بمبلغ : {$recharge->amount} جنيه\n" .
                "🆔 رقم المعاملة: #{$recharge->id}\n" .
                "📅 الوقت: " . now()->format('Y-m-d h:i A');

            // Step 1: Send TEXT notification (guaranteed)
            $textPayload = [
                'number' => $number,
                'type' => 'text',
                'message' => $message,
                'instance_id' => $instanceId,
                'access_token' => $accessToken
            ];

            $textResponse = Http::timeout(15)->post(self::$baseUrl . '/send', $textPayload);
            Log::info('AdminNotification: Text sent [' . $textResponse->status() . ']: ' . $textResponse->body());
        } catch (\Exception $e) {
            // Log error but don't break the user flow
            Log::error("Admin Notification Error: " . $e->getMessage());
        }
    }
}
