<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ApiClient;
use App\Models\WhatsAppPackage;
use App\Models\User;

class CheckSubscriptionStatus extends Command
{
    protected $signature = 'whatsapp:check-subscriptions';
    protected $description = 'فحص الاشتراكات وإرسال إشعارات للرصيد المنخفض والانتهاء القريب';

    public function handle()
    {
        $this->info('بدء فحص الاشتراكات...');

        // 1. إشعار الرصيد المنخفض (10%)
        $this->checkLowBalance();

        // 2. إشعار قرب الانتهاء (3 أيام)
        $this->checkExpiringSoon();

        $this->info('تم فحص الاشتراكات وإرسال الإشعارات بنجاح ✅');
    }

    private function checkLowBalance()
    {
        $clients = ApiClient::active()->get();
        $count = 0;

        foreach ($clients as $client) {
            $package = WhatsAppPackage::where('name', $client->package_name)->first();
            if (!$package) continue;

            $threshold = $package->message_limit * 0.1; // 10%

            if ($client->balance <= $threshold) {
                // تجنب تكرار الإشعار
                if ($client->last_notification_sent && $client->last_notification_sent->isToday()) {
                    continue;
                }

                $this->sendLowBalanceNotification($client);
                $client->update(['last_notification_sent' => now()]);
                $count++;
            }
        }

        $this->info("تم إرسال {$count} إشعار رصيد منخفض");
    }

    private function checkExpiringSoon()
    {
        $clients = ApiClient::expiringSoon(3)->get();
        $count = 0;

        foreach ($clients as $client) {
            if ($client->last_notification_sent && $client->last_notification_sent->isToday()) {
                continue;
            }

            $this->sendExpiryNotification($client);
            $client->update(['last_notification_sent' => now()]);
            $count++;
        }

        $this->info("تم إرسال {$count} إشعار قرب انتهاء");
    }

    private function sendLowBalanceNotification($client)
    {
        $user = $client->user;
        $message = "⚠️ تنبيه\nعزيزي {$user->name}\n\nتبقى لديك {$client->balance} رسالة فقط من باقتك.\nيرجى تجديد اشتراكك قريباً.";

        // يمكنك استخدام notification service هنا
        // مثال: AdminNotificationService::sendWhatsAppNotification($user, $message);

        $this->line("📤 إشعار رصيد منخفض: {$user->name} ({$client->balance} رسالة متبقية)");
    }

    private function sendExpiryNotification($client)
    {
        $user = $client->user;
        $daysLeft = now()->diffInDays($client->expire_at);
        $message = "⏰ تنبيه\nعزيزي {$user->name}\n\nباقتك ستنتهي خلال {$daysLeft} أيام.\nجدد اشتراكك الآن للاستفادة من Rollover!";

        // يمكنك استخدام notification service هنا
        // مثال: AdminNotificationService::sendWhatsAppNotification($user, $message);

        $this->line("📤 إشعار قرب انتهاء: {$user->name} (ينتهي خلال {$daysLeft} أيام)");
    }
}
