<?php

use App\Http\Controllers\AnnouncementControllers\HomeAnnouncementController;
use Illuminate\Support\Facades\Route;

Route::Group(['prefix'=>'home/announcement','middleware' => ['auth:sanctum']], function(){
    Route::post('',[HomeAnnouncementController::class, "store"]);
});

