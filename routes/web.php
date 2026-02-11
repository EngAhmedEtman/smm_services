<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteServiceController;
use App\Http\Controllers\Api\WhatsappController;
use App\Http\Controllers\Api\WhatsappContactController;
use App\Http\Controllers\RechargeController;
use App\Http\Controllers\WhatsappCampaignController;
use App\Http\Controllers\WhatsappMessageController;

require __DIR__ . '/auth.php';

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/new-order', [ServiceController::class, 'showForm'])->name('showForm')->middleware('auth');
    Route::post('/new-order', [ServiceController::class, 'addOrder'])->name('addOrder')->middleware('auth');
    Route::get('/services', [ServiceController::class, 'allServices'])->name('services.index')->middleware('auth');
    Route::post('/services/favorite', [FavoriteServiceController::class, 'makeFavorite'])->name('services.makeFavorite')->middleware('auth');
    Route::get('/services/favorites', [FavoriteServiceController::class, 'index'])->name('services.favorites')->middleware('auth');
    Route::get('/status', [ServiceController::class, 'status'])->name('status')->middleware('auth');
    Route::post('/order/{order}/refill', [ServiceController::class, 'refillOrder'])->name('order.refill')->middleware('auth');
    Route::post('/order/{order}/cancel', [ServiceController::class, 'cancelOrder'])->name('order.cancel')->middleware('auth');


    Route::get('/whatsapp/connect', [WhatsappController::class, 'connect'])->name('whatsapp.connect');
    Route::get('/whatsapp/scan/{instance_id}', [WhatsappController::class, 'scanInstance'])->name('whatsapp.scan');
    Route::get('/whatsapp/accounts', [WhatsappController::class, 'index'])->name('whatsapp.accounts');
    Route::get('/whatsapp/test', [WhatsappController::class, 'test'])->name('whatsapp.test');
    Route::post('/whatsapp/send', [WhatsappController::class, 'sendMessage'])->name('whatsapp.send');


    Route::get('/whatsapp/debug/{instance_id}', [WhatsappController::class, 'debugStatus'])->name('whatsapp.debug');
    Route::get('/whatsapp/reboot/{instance_id}', [WhatsappController::class, 'rebootInstance'])->name('whatsapp.reboot');
    Route::get('/whatsapp/reconnect/{instance_id}', [WhatsappController::class, 'reconnect'])->name('whatsapp.reconnect');
    Route::post('/whatsapp/reset/{instance_id}', [WhatsappController::class, 'resetInstance'])->name('whatsapp.reset');

    Route::get('/whatsapp/contacts', [WhatsappContactController::class, 'index'])->name('whatsapp.contacts');
    Route::get('/whatsapp/contacts/create', [WhatsappContactController::class, 'create'])->name('whatsapp.contact.create');
    Route::post('/whatsapp/contacts', [WhatsappContactController::class, 'store'])->name('whatsapp.contact.store');
    Route::get('/whatsapp/contacts/{id}/edit', [WhatsappContactController::class, 'edit'])->name('whatsapp.contact.edit');
    Route::put('/whatsapp/contacts/{id}', [WhatsappContactController::class, 'update'])->name('whatsapp.contact.update');
    Route::delete('/whatsapp/contacts/{id}', [WhatsappContactController::class, 'destroy'])->name('whatsapp.contact.delete');

    Route::get('/whatsapp/buttons', [WhatsappController::class, 'buttons'])->name('whatsapp.buttons');

    // Campaigns Routes
    Route::get('/whatsapp/campaigns', [WhatsappCampaignController::class, 'index'])->name('whatsapp.campaigns.index');
    Route::get('/whatsapp/campaigns/create', [WhatsappCampaignController::class, 'create'])->name('whatsapp.campaigns.create');
    Route::post('/whatsapp/campaigns', [WhatsappCampaignController::class, 'store'])->name('whatsapp.campaigns.store');
    Route::post('/whatsapp/campaigns/{id}/status', [WhatsappCampaignController::class, 'updateStatus'])->name('whatsapp.campaigns.status');
    Route::delete('/whatsapp/campaigns/{id}', [WhatsappCampaignController::class, 'destroy'])->name('whatsapp.campaigns.destroy');
    Route::get('/whatsapp/campaigns/{id}/process', [WhatsappCampaignController::class, 'process'])->name('whatsapp.campaigns.process');
    Route::get('/whatsapp/campaigns/{id}/progress', [WhatsappCampaignController::class, 'progress'])->name('whatsapp.campaigns.progress');

    // Messages Templates Routes
    Route::resource('/whatsapp/messages', WhatsappMessageController::class, ['names' => 'whatsapp.messages']);


    // WhatsApp Webhook — must be public (called by Wolfix API externally)


    // Static Pages
    Route::get('/recharge', [RechargeController::class, 'create'])->name('recharge');
    Route::post('/recharge', [RechargeController::class, 'store'])->name('recharge.store');

    // Admin Settings (Super Admin)
    Route::middleware(['super_admin'])->group(function () {
        Route::get('/admin/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('admin.settings.index');
        Route::post('/admin/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('admin.settings.update');

        Route::get('/admin/recharges', [\App\Http\Controllers\Admin\SettingsController::class, 'recharges'])->name('admin.recharges.index');
        Route::post('/admin/recharges/{id}/approve', [\App\Http\Controllers\Admin\SettingsController::class, 'approveRecharge'])->name('admin.recharges.approve');
        Route::post('/admin/recharges/{id}/reject', [\App\Http\Controllers\Admin\SettingsController::class, 'rejectRecharge'])->name('admin.recharges.reject');

        Route::get('/admin/users', [\App\Http\Controllers\Admin\SettingsController::class, 'users'])->name('admin.users.index');
        Route::get('/admin/tickets', [\App\Http\Controllers\Admin\SettingsController::class, 'tickets'])->name('admin.tickets.index');
    });
})->middleware(['auth', 'verified']); // Ensure auth group is closed correctly




// WhatsApp Webhook — must be public (called by Wolfix API externally)
Route::post('/whatsapp/webhook', [WhatsappController::class, 'webhook'])->name('whatsapp.webhook');

// Public Pages (no auth required)
Route::get('/call-us', function () {
    return view('CallUs');
})->name('call-us');

Route::get('/privacy-policy', function () {
    return view('privacypolicy');
})->name('privacy-policy');

// File Proxy: Serve storage files without symlink (shared hosting fix)
Route::get('/file/{path}', function ($path) {
    // Mime types map for images
    $mimeTypes = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'webp' => 'image/webp',
        'pdf' => 'application/pdf',
    ];

    // Determine file location
    $filePath = null;
    $locations = [
        storage_path('app/public/' . $path),
        public_path('uploads/' . $path),
        public_path($path),
    ];

    foreach ($locations as $loc) {
        if (file_exists($loc)) {
            $filePath = $loc;
            break;
        }
    }

    if (!$filePath) {
        \Illuminate\Support\Facades\Log::warning("File not found in any location for: {$path}");
        abort(404);
    }

    // Get correct mime type
    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    $mime = $mimeTypes[$ext] ?? mime_content_type($filePath);

    // Return raw file with clean headers (important for WhatsApp API)
    return response(file_get_contents($filePath), 200, [
        'Content-Type' => $mime,
        'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"',
        'Content-Length' => filesize($filePath),
        'Cache-Control' => 'public, max-age=86400',
    ]);
})->where('path', '.*')->name('file.serve');

// Cron Trigger: Process campaigns via URL (for shared hosting without shell cron)
Route::get('/cron/campaigns/{key}', function ($key) {
    // Simple secret key to prevent unauthorized access
    if ($key !== 'etman2026') {
        abort(403);
    }

    \Illuminate\Support\Facades\Artisan::call('campaign:process');
    $output = \Illuminate\Support\Facades\Artisan::output();

    return response($output, 200)->header('Content-Type', 'text/plain');
});
