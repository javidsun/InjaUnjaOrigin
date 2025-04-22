<?php

use App\Http\Controllers\HomeAnnouncementController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->post('/home/announcements',[HomeAnnouncementController::class, "store"]);
