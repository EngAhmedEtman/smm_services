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
use App\Http\Controllers\Api\InstanceController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ApiClientController;

require __DIR__ . '/auth.php';

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

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


    // WhatsApp Accounts
    Route::get('/whatsapp/accounts', [WhatsappController::class, 'index'])->name('whatsapp.accounts');
    Route::get('/whatsapp/connect', [WhatsappController::class, 'connect'])->name('whatsapp.connect');
    Route::get('/whatsapp/scan/{instance_id}', [WhatsappController::class, 'scanInstance'])->name('whatsapp.scan');
    Route::get('/whatsapp/reboot/{instance_id}', [WhatsappController::class, 'rebootInstance'])->name('whatsapp.reboot');
    Route::post('/whatsapp/reset/{instance_id}', [WhatsappController::class, 'resetInstance'])->name('whatsapp.reset');
    Route::get('/whatsapp/reconnect/{instance_id}', [WhatsappController::class, 'reconnect'])->name('whatsapp.reconnect');
    Route::post('/whatsapp/update-number', [WhatsappController::class, 'updateNumber'])->name('whatsapp.updateNumber');
    Route::get('/whatsapp/debug/{instance_id}', [WhatsappController::class, 'debugStatus'])->name('whatsapp.debug');

    // WhatsApp Contacts
    Route::get('/whatsapp/contacts', [WhatsappContactController::class, 'index'])->name('whatsapp.contacts');
    Route::get('/whatsapp/contacts/create', [WhatsappContactController::class, 'create'])->name('whatsapp.contacts.create');
    Route::post('/whatsapp/contacts', [WhatsappContactController::class, 'store'])->name('whatsapp.contacts.store');
    Route::get('/whatsapp/contacts/{id}/edit', [WhatsappContactController::class, 'edit'])->name('whatsapp.contacts.edit');
    Route::put('/whatsapp/contacts/{id}', [WhatsappContactController::class, 'update'])->name('whatsapp.contacts.update');
    Route::delete('/whatsapp/contacts/{id}', [WhatsappContactController::class, 'destroy'])->name('whatsapp.contacts.destroy');

    // WhatsApp Buttons
    Route::get('/whatsapp/buttons', [WhatsappController::class, 'buttons'])->name('whatsapp.buttons');

    // WhatsApp Campaigns
    Route::resource('/whatsapp/campaigns', WhatsappCampaignController::class, ['names' => 'whatsapp.campaigns'])->except(['destroy']);
    Route::delete('/whatsapp/campaigns/{id}', [WhatsappCampaignController::class, 'destroy'])->name('whatsapp.campaigns.destroy');
    Route::get('/whatsapp/campaigns/{id}/process', [WhatsappCampaignController::class, 'process'])->name('whatsapp.campaigns.process');
    Route::get('/whatsapp/campaigns/{id}/progress', [WhatsappCampaignController::class, 'progress'])->name('whatsapp.campaigns.progress');
    Route::post('/whatsapp/campaigns/{id}/status', [WhatsappCampaignController::class, 'updateStatus'])->name('whatsapp.campaigns.status');

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
        Route::post('/admin/users/{id}/toggle-status', [\App\Http\Controllers\Admin\SettingsController::class, 'toggleUserStatus'])->name('admin.users.toggle-status');
        Route::post('/admin/users/{id}/add-credit', [\App\Http\Controllers\Admin\SettingsController::class, 'addCredit'])->name('admin.users.add-credit');

        Route::get('/admin/tickets', [\App\Http\Controllers\Admin\SettingsController::class, 'tickets'])->name('admin.tickets.index');

        // WhatsApp Assets (Random Text & Welcome Messages) - Moved to Admin
        Route::get('/admin/assets', [\App\Http\Controllers\WhatsappAssetsController::class, 'index'])->name('admin.assets.index');
        Route::post('/admin/assets/random', [\App\Http\Controllers\WhatsappAssetsController::class, 'storeRandom'])->name('admin.assets.storeRandom');
        Route::delete('/admin/assets/random/{id}', [\App\Http\Controllers\WhatsappAssetsController::class, 'destroyRandom'])->name('admin.assets.destroyRandom');
        Route::post('/admin/assets/welcome', [\App\Http\Controllers\WhatsappAssetsController::class, 'storeWelcome'])->name('admin.assets.storeWelcome');
        Route::delete('/admin/assets/welcome/{id}', [\App\Http\Controllers\WhatsappAssetsController::class, 'destroyWelcome'])->name('admin.assets.destroyWelcome');

        // WhatsApp Pricing Tiers
        Route::resource('/admin/pricing', \App\Http\Controllers\Admin\PricingTierController::class, ['names' => 'admin.pricing'])->except(['create', 'edit', 'show']);
    });

    Route::get('create-token', [ApiClientController::class, 'create'])->name('create-token');
    Route::post('create-token', [ApiClientController::class, 'createToken'])->name('create-token');
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

Route::get('/services-list', [ServiceController::class, 'publicList'])->name('public.services');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/support/tickets', function () {
    return view('coming-soon');
})->name('tickets.index');

Route::get('/api-docs', function () {
    return view('coming-soon');
})->name('api.docs');

// Temporary: Clear all caches
Route::get('/clear-cache-2026', function () {
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    return '✅ All caches cleared!';
});

// Cron Trigger: Process campaigns via URL (for shared hosting without shell cron)
Route::get('/run-campaigns-etman2026', function () {
    \Illuminate\Support\Facades\Log::info('Cron Trigger: Accessed via URL');

    \Illuminate\Support\Facades\Artisan::call('campaign:process');
    $output = \Illuminate\Support\Facades\Artisan::output();

    \Illuminate\Support\Facades\Log::info('Cron Trigger: Output: ' . $output);

    return response($output ?: 'Done', 200)->header('Content-Type', 'text/plain');
});

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
