<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/houses', function () {
    return Inertia::render('Users/Reserv/HousesAds');
});

Route::get('/vehicles', function () {
    return Inertia::render('layout/sections/Groups/Travel Ads/TravelersContent');
});

Route::get('/events', function () {
    return Inertia::render('layout/sections/Groups/Event Ads/EventsContent');
});

Route::get('/travelers', function () {
    return Inertia::render('layout/sections/Groups/Vehicles Ads/VehiclesContent');
});
Route::get('/Messages', function () {
    return Inertia::render('Users/Messages/Messages');
});

Route::get('/UserFinance', function () {
    return Inertia::render('Users/UserFinance');
});
Route::get('/UserSettings', function () {
    return Inertia::render('Users/UserSettings');
});
