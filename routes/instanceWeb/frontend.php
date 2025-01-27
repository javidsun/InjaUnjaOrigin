<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


$files = glob(__DIR__ . '/frontend/*.php');
foreach ($files as $file) {
    require $file;
}

Route::group(['middleware' => 'auth:sanctum'], function () {

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
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
});
Route::get('', function () {
    return Inertia::render('Welcome');
});
Route::get('/register', function () {
    return Inertia::render('RegisterUser');
});
Route::get('/home', function () {
    return Inertia::render('Home');
});
Route::get('/login', function () {
    return Inertia::render('Login');
})->name('login');



