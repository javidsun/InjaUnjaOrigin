<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::get('/functional', function () {
    return Inertia::render('Admin/dashboard_main/functional');
});



Route::get('/warning', function () {
    return Inertia::render('Admin/dashboard_main/warning');
});

Route::get('/UserTable', function () {
    return Inertia::render('Admin/dashboard_main/UserTable');
});

Route::get('/BasicStatistics', function () {
    return Inertia::render('Admin/dashboard_main/BasicStatistics');
});
Route::get('/Services', function () {
    return Inertia::render('Admin/dashboard_main/Services');
});

Route::get('/ads_management', function () {
    return Inertia::render('Admin/Sidebar_sections/ads_management');
});
Route::get('/Analytics', function () {
    return Inertia::render('Admin/Sidebar_sections/Analytics');
});
Route::get('/Finance', function () {
    return Inertia::render('Admin/Sidebar_sections/Finance');
});
Route::get('/Notifications', function () {
    return Inertia::render('Admin/Sidebar_sections/Notifications');
});
Route::get('/Reports', function () {
    return Inertia::render('Admin/Sidebar_sections/Reports');
});
Route::get('/ReservationManagement', function () {
    return Inertia::render('Admin/Sidebar_sections/ReservationManagement');
});
Route::get('/Settings', function () {
    return Inertia::render('Admin/Sidebar_sections/Settings');
});
Route::get('/SupportSystem', function () {
    return Inertia::render('Admin/Sidebar_sections/SupportSystem');
});
Route::get('/UserManagement', function () {
    return Inertia::render('Admin/Sidebar_sections/UserManagement');
});
    Route::get('/AdsHouse', function () {
    return Inertia::render('Admin/Sidebar_sections/AdsHouse');
});
Route::get('/CancellationsDetails', function () {
    return Inertia::render('Admin/Sidebar_sections/CancellationsDetails');
});
Route::get('/AdsTraveler', function () {
    return Inertia::render('Admin/Sidebar_sections/AdsTraveler');
});
