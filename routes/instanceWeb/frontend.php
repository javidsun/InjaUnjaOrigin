<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


$files = glob(__DIR__ . '/frontend/*.php');
foreach ($files as $file) {
    require $file;
}


Route::get('/add-property', function () {
    return Inertia::render('AddProperty');
});


Route::get('/gift-card', function () {
    return Inertia::render('GiftCard');
});

Route::get('/inja-unja', function () {
    return Inertia::render('InjaUnja');
});



