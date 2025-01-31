<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {
    // auth routes
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
    });

    Route::middleware(['auth:api'])->group(function () {
        //account routes
        Route::prefix('account')->group(function () {
            Route::get('/', [AuthController::class, 'me']);
            Route::get('/logout', [AuthController::class, 'logout']);
        });

        //order routes
        Route::apiResource('orders', OrderController::class);

        // payment routes
        Route::prefix('payments')->group(function () {
            Route::get('/', [PaymentController::class, 'index']);
            Route::post('store/{order}', [PaymentController::class, 'store']);
        });
    });
});
