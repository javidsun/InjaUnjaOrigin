<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
});
Route::get('/AdminDashboard', function () {
    return Inertia::render('Admin/AdminDashboard');
});

Route::get('/UserDashboard', function () {
    return Inertia::render('Users/UserDashboard/UserDashboard');
});

Route::get('/UserProfile', function () {
    return Inertia::render('Users/UserDashboard/UserProfile');
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/UserProfile', function () {
        return Inertia::render('Users/UserDashboard/UserProfile');
    })->name('profile');

    Route::get('/UserDashboard', function () {
        return Inertia::render('Users/UserDashboard/UserDashboard');
    })->name('dashboard');
});

Route::post('/api/complete-profile', [ProfileController::class, 'completeProfile']);
Route::get('/MyReservations', function () {
    return Inertia::render('Users/Reserv/MyReservations');
})->name('MyReservations');

Route::get('/ReservationDetails', function () {
    return Inertia::render('Users/Reserv/ReservationDetails');
})->name('ReservationDetails');

Route::get('/notifications', function () {
    return Inertia::render('Users/UserDashboard/Notifications');
})->name('notifications');

Route::get('/UserFinance', function () {
    return Inertia::render('Users/UserDashboard/UserFinance');
})->name('UserFinance');

Route::get('/UserSettings', function () {
    return Inertia::render('Users/UserDashboard/UserSettings');
})->name('UserSettings');

Route::get('/Support', function () {
    return Inertia::render('Users/Support');
})->name('Support');
