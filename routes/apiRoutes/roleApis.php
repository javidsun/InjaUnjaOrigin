<?php

use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::Group(['prefix' => 'role'], function () {
   Route::post('create', [RoleController::class, 'create']);
});
