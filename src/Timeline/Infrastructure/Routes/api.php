<?php

use Illuminate\Support\Facades\Route;
use src\Timeline\Presentation\HTTP\TimelineForYouController;
use src\Timeline\Presentation\HTTP\TimelineFollowingController;


Route::prefix('timeline')->group(function () {
    Route::get('/for-you', [TimelineForYouController::class, 'index']);
    Route::get('/following/{userId}', [TimelineFollowingController::class, 'index']);
}); 