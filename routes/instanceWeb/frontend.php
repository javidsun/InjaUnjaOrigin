<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::group(['middleware' => 'auth:sanctum'], function () {

});
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
});

Route::get('/', function () {
    return Inertia::render('Home2');
})->name('home2');


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


Route::get('/add-property', function () {
    return Inertia::render('AddProperty');
});

Route::get('/gift-card', function () {
    return Inertia::render('GiftCard');
});

Route::get('/inja-unja', function () {
    return Inertia::render('InjaUnja');
});

Route::get('/help-center', function () {
    return Inertia::render('HelpCenter');
});

