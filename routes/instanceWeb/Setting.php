<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/SettingModal', function () {
    return Inertia::render('Users/SettingModals/SettingModal');
});
Route::get('/SecurityModal', function () {
    return Inertia::render('Users/SettingModals/SecurityModal');
});
Route::get('/PaymentsModal', function () {
    return Inertia::render('Users/SettingModals/PaymentsModal');
});
Route::get('/AccessModal', function () {
    return Inertia::render('Users/SettingModals/AccessModal');
});
Route::get('/CurrencyModal', function () {
    return Inertia::render('Users/SettingModals/CurrencyModal');
});
Route::get('/NotificationsModals', function () {
    return Inertia::render('Users/SettingModals/NotificationsModals');
});
Route::get('/privacySharing', function () {
    return Inertia::render('Users/SettingModals/privacySharing');
});
Route::get('/guide', function () {
    return Inertia::render('Users/SettingModals/guide');
});
Route::get('/GiftModal', function () {
    return Inertia::render('Users/SettingModals/GiftModal');
});
Route::get('/Suggestfriend', function () {
    return Inertia::render('Users/SettingModals/Suggestfriend');
});
Route::get('/SupportModal', function () {
    return Inertia::render('Users/SettingModals/SupportModal');
});
Route::get('/ReportModal', function () {
    return Inertia::render('Users/SettingModals/ReportModal');
});
Route::get('/HowItWorksModal', function () {
    return Inertia::render('Users/SettingModals/HowItWorksModal');
});
Route::get('/FeedbackModal', function () {
    return Inertia::render('Users/SettingModals/FeedbackModal');
});
Route::get('/Terms', function () {
    return Inertia::render('Users/SettingModals/Terms');
});
Route::get('/Policy', function () {
    return Inertia::render('Users/SettingModals/Policy');
});
Route::get('/InjaUnja', function () {
    return Inertia::render('layout/menu_component/InjaUnja');
});
Route::get('/GiftCardatFirst', function () {
    return Inertia::render('layout/menu_component/GiftCardatFirst');
});
