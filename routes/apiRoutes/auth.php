<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OAuthController;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth',
    'middleware' => ['auth:sanctum', 'hasIdpSession',],
], function () {
    Route::post('/register', function (RegisterRequest $request, AuthController $authController) {
    });

    Route::get('/auth/{provider}/redirect', [OAuthController::class, 'redirect']);

    Route::get('/auth/{provider}/callback', [OAuthController::class, 'callback']);
}
);


