<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$smm = app(App\Services\SmmService::class);
$ids = [115112, 115113, 115114];

echo "Fetching status for IDs: " . implode(', ', $ids) . "\n";

try {
    $results = $smm->getMultipleOrdersStatus($ids);
    echo "Raw Response:\n";
    print_r($results);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
