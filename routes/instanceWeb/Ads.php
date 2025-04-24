<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/createAdForm', function () {
    return Inertia::render('Ad/createAdForm');
});
Route::get('/AdsList', function () {
    return Inertia::render('Ad/AdsList');
});
Route::get('/CategoryFilter', function () {
    return Inertia::render('Ad/CategoryFilter');
});
Route::get('/MyAds', function () {
    return Inertia::render('Ad/MyAds');
});

Route::get('/MyReservations', function () {
    return Inertia::render('Users/Reserv/MyReservations');
});




