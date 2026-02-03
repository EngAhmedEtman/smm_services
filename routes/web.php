<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Support\Facades\Route;


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
    Route::get('/status', [ServiceController::class, 'status'])->name('status')->middleware('auth');


});




