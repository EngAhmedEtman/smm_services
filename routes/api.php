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
    Route::get('/test', [InstanceController::class, 'test']);
    Route::get('/create_instance', [InstanceController::class, 'create_instance']);
    Route::get('/getQrCode', [InstanceController::class, 'getQrCode']);
    Route::get('/setWebhook', [InstanceController::class, 'setWebhook']);
    Route::get('/rebootInstance', [InstanceController::class, 'rebootInstance']);
    Route::get('/resetInstance', [InstanceController::class, 'resetInstance']);
    Route::get('/reconnectInstance', [InstanceController::class, 'reconnectInstance']);

    // مسارات إرسال الرسائل
    Route::post('/send_text', [MessageController::class, 'sendText']);
    Route::post('/send_media', [MessageController::class, 'sendMedia']);
    Route::post('/send_group', [MessageController::class, 'sendGroup']);
});




// Route::get('/debug-http-json', function () {
//     \Illuminate\Support\Facades\Http::fake([
//         '*' => \Illuminate\Support\Facades\Http::response(['foo' => 'bar'], 200),
//     ]);

//     $response = \Illuminate\Support\Facades\Http::post('http://test.com');

//     return [
//         'class' => get_class($response),
//         'has_json' => method_exists($response, 'json'),
//         'json_output' => $response->json(),
//     ];
// });



