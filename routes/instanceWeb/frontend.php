<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::group(['middleware' => 'auth:sanctum'], function () {

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



