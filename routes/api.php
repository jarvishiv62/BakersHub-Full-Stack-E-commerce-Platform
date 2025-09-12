<?php
// routes/api.php
use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::middleware(['auth:sanctum'])->group(function () {
    // Order routes accessible by all authenticated users
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::post('/', [OrderController::class, 'store']);
        Route::get('/{order}', [OrderController::class, 'show']);
        Route::patch('/{order}/cancel', [OrderController::class, 'cancel']);
        
        // Admin-only routes
        Route::middleware(['admin'])->group(function () {
            Route::put('/{order}', [OrderController::class, 'update']);
            Route::get('/statistics', [OrderController::class, 'statistics']);
        });
    });


});

Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1'); // rate-limit brute force

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});