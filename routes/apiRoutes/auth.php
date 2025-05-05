<?php

use App\Http\Controllers\AuthControllers\AuthController;
use App\Http\Controllers\AuthControllers\OAuthController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
    'prefix' => 'auth',
    'middleware' => ['auth:sanctum', 'hasIdpSession'],
],
    function () {
        Route::post('/register', [AuthController::class, 'register']);

        Route::get('/auth/{provider}/redirect', [OAuthController::class, 'redirect']);

        Route::get('/auth/{provider}/callback', [OAuthController::class, 'callback']);
    }
);
