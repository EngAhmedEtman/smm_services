<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Order;
use App\Services\SmmService;
use Illuminate\Support\Facades\Log;

// 1. Fetch Orders
$orders = Order::whereIn('smm_order_id', [115112, 115113, 115114])->get();
echo "Found " . $orders->count() . " orders.\n";

$smmService = app(SmmService::class);
$ids = $orders->pluck('smm_order_id')->toArray();

// 2. Fetch API Status
$apiResults = $smmService->getMultipleOrdersStatus($ids);
echo "API Results:\n";
print_r($apiResults);

// 3. Update Orders
foreach ($orders as $order) {
    $externalId = $order->smm_order_id;
    if (isset($apiResults[$externalId])) {
        $apiStatus = $apiResults[$externalId];
        $newStatus = strtolower($apiStatus['status']);

        echo "Updating Order {$order->id} (SMM: {$externalId}): {$order->status} -> {$newStatus}\n";

        $order->update([
            'status'  => $newStatus,
            'remains' => $apiStatus['remains'] ?? $order->remains,
            'start_count' => !empty($apiStatus['start_count']) ? $apiStatus['start_count'] : $order->start_count,
            'refill_available' => $apiStatus['refill'] ?? false,
            'cancel_available' => $apiStatus['cancel'] ?? false,
        ]);

        echo "Updated.\n";
    } else {
        echo "Order {$externalId} not found in API response.\n";
    }
}

echo "Done.\n";
