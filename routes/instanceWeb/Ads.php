<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;

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

Route::get('/api/categories', [CategoryController::class, 'getCategories']);
Route::get('/api/ads', [AdController::class, 'getAds']);
Route::post('/api/ads', [AdController::class, 'createAd']);
Route::delete('/api/ads/{id}', [AdController::class, 'deleteAd']);
Route::middleware('auth:api')->get('/user', [UserController::class, 'getUserDetails']);
Route::get('/api/reservations', [ReservationController::class, 'getUserReservations'])->middleware('auth:api');
Route::post('/api/reservations', [ReservationController::class, 'createReservation'])->middleware('auth:api');
Route::post('/api/bookings/{id}/confirm', [BookingController::class, 'confirmBooking'])->middleware('auth:api');
Route::post('/api/bookings/{id}/cancel', [BookingController::class, 'cancelBooking'])->middleware('auth:api');



