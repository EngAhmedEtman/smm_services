<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    /**
     * Handle the Order "updated" event.
     * When an order is cancelled, refund the price to the user's balance.
     */
    public function updated(Order $order): void
    {
        $cancelledStatuses = ['canceled', 'cancelled'];

        // Only trigger refund if status just changed to a cancelled state
        if (
            in_array(strtolower($order->status), $cancelledStatuses) &&
            $order->isDirty('status') &&
            !in_array(strtolower($order->getOriginal('status')), $cancelledStatuses)
        ) {
            $this->refundOrder($order);
        }
    }

    /**
     * Refund the order price back to the user's balance.
     */
    protected function refundOrder(Order $order): void
    {
        $user = $order->user;

        if (!$user) {
            Log::warning("OrderObserver: Cannot refund order #{$order->id} — user not found.");
            return;
        }

        if ($order->price <= 0) {
            Log::info("OrderObserver: Order #{$order->id} has zero price, skipping refund.");
            return;
        }

        // Prevent double refund — check if already refunded
        if ($order->refunded_at) {
            Log::info("OrderObserver: Order #{$order->id} already refunded, skipping.");
            return;
        }

        // Increment user balance
        $user->increment('balance', $order->price);

        // Mark as refunded to prevent double refund
        // Use updateQuietly to avoid triggering the observer again
        $order->updateQuietly(['refunded_at' => now()]);

        Log::info("OrderObserver: Refunded {$order->price} to user #{$user->id} ({$user->name}) for order #{$order->id}.");

        // Notify user via WhatsApp if possible
        try {
            \App\Services\AdminNotificationService::notifyOrderRefunded($user, $order);
        } catch (\Exception $e) {
            Log::warning("OrderObserver: WhatsApp notify failed for refund of order #{$order->id}: " . $e->getMessage());
        }
    }
}
