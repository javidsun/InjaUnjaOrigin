<?php


use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

$files = glob(__DIR__ . '/instanceWeb/*.php');

foreach ($files as $file) {
    require $file;
}



Route::middleware(['auth', 'role_or_permission:admin|host|manage users'])
    ->get('/admin/dashboard', [RoleController::class, 'index'])
    ->name('admin.dashboard');






