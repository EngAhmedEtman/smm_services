<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\InstanceController;
use App\Http\Controllers\Api\MessageController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// مسارات محمية بـ API Key
Route::middleware(['api.key'])->group(function () {
    // مسارات خاصة بحالة العميل والـ Instance
    Route::get('/test',[InstanceController::class, 'test']);
    Route::post('/create-instance', [InstanceController::class, 'createInstance']);
    Route::post('/get-qrcode', [InstanceController::class, 'getQrCode']);
    Route::get('/api-instance-status', [InstanceController::class, 'status'])->name('api.instance.status');

    // مسارات إرسال الرسائل
    Route::post('/send', [MessageController::class, 'sendText']);
    Route::post('/send-media', [MessageController::class, 'sendMedia']);
    Route::post('/send-group', [MessageController::class, 'sendGroup']);
});
