<?php
// Temporary test file — delete after use
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->handle(
    Illuminate\Http\Request::capture()
);

use App\Models\Recharge;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

$recharge = Recharge::with('user')->latest()->first();

$instanceId = Setting::where('key', 'admin_whatsapp_instance_id')->value('value');
$accessToken = Setting::where('key', 'admin_whatsapp_access_token')->value('value');
$adminPhone = Setting::where('key', 'admin_receiver_number')->value('value');

echo "=== DEBUG ===\n";
echo "Instance ID: $instanceId\n";
echo "Token: $accessToken\n";
echo "Admin Phone: $adminPhone\n";
echo "Recharge ID: {$recharge->id}\n";
echo "User: {$recharge->user->name}\n";
echo "Image: {$recharge->proof_image}\n";

$user = $recharge->user;
$number = preg_replace('/[^0-9]/', '', $adminPhone);

$message = "🔔 *تست إشعار إيداع*\n\n" .
    "👤 العميل: {$user->name}\n" .
    "💰 المبلغ: {$recharge->amount} جنيه\n" .
    "🆔 رقم: #{$recharge->id}";

// Try TEXT first
$payload = [
    'number' => $number,
    'type' => 'text',
    'message' => $message,
    'instance_id' => $instanceId,
    'access_token' => $accessToken
];

echo "\n=== Sending TEXT ===\n";
echo "Payload: " . json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n";

try {
    $response = Http::timeout(15)->post('https://wolfixbot.com/api/send', $payload);
    echo "Status: " . $response->status() . "\n";
    echo "Response: " . $response->body() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
