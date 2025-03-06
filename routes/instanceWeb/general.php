<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home2');
})->name('home2');

Route::get('/help-center', function () {
    return Inertia::render('HelpCenter');
});

Route::get('/inja-unja', function () {
    return Inertia::render('InjaUnja');
});
