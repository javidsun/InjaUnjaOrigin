<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/houses', function () {
    return Inertia::render('Houses');
})->name('houses');

Route::get('/vehicles', function () {
    return Inertia::render('Vehicles');
})->name('vehicles');

Route::get('/events', function () {
    return Inertia::render('Events');
})->name('events');

Route::get('/travelers', function () {
    return Inertia::render('Travelers');
})->name('travelers');
