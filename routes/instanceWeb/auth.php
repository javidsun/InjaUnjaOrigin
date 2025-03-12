<?php

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
