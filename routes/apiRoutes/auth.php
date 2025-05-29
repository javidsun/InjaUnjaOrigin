<?php

use App\Http\Controllers\AuthControllers\AuthController;
use App\Http\Controllers\AuthControllers\OAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rotte pubbliche per autenticazione
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) { // TODO ; TO Change because is just an example
    return $request->user();
});

Route::group(
    [
        'prefix' => 'auth',
        'middleware' => ['auth:sanctum', 'session'],
    ],
    function () {

        Route::get('/auth/{provider}/redirect', [OAuthController::class, 'redirect']);

        Route::get('/auth/{provider}/callback', [OAuthController::class, 'callback']);
    }
);
