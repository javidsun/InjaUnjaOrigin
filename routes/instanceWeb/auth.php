<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/RegisterUser', function () {
    return Inertia::render('RegisterUser');
});

Route::get('/Login', function () {
    return Inertia::render('Login');
})->name('Login');

Route::get('/twoStep', function () {
    return Inertia::render('layout/menu_component/two-steps');
});

Route::get('/reset-password', function () {
    return Inertia::render('layout/menu_component/reset-password');
});

Route::get('/verify-email', function () {
    return Inertia::render('layout/menu_component/verify-email');
});
Route::get('/forgot-password', function () {
    return Inertia::render('layout/menu_component/forgot-password');
})->name('forgot-password');



Route::post('/register', [AuthController::class, 'register']);
Route::post('/api/register', [AuthController::class, 'register']);
Route::post('/api/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('/api/user', [AuthController::class, 'me']);
Route::post('/api/forgot-password', [AuthController::class, 'sendResetLink']);
Route::post('/api/reset-password', [AuthController::class, 'resetPassword']);
Route::post('/api/verify-email', [AuthController::class, 'verifyEmail']);
Route::post('/api/two-factor', [AuthController::class, 'verifyTwoFactor']);
