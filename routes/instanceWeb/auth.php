<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/register', function () {
    return Inertia::render('RegisterUser');
});

Route::get('/login', function () {
    return Inertia::render('Login');
})->name('login');

Route::get('/twoStep', function () {
    return Inertia::render('layout/menu_component/two-steps');
});

Route::get('/reset-password', function () {
    return Inertia::render('layout/menu_component/reset-password');
});

Route::get('/verify-email', function () {
    return Inertia::render('layout/menu_component/verify-email');
});
