<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\V1\NotificationHubController;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login'])->name('login');

Route::prefix('v1/notifications')->middleware(['auth:sanctum'])->group(function () {
    Route::post('dispatch', [NotificationHubController::class, 'dispatch'])
        ->name('v1.notifications.dispatch');
});
