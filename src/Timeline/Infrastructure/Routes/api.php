<?php

use Illuminate\Support\Facades\Route;
use src\Timeline\Presentation\HTTP\TimelineController;


Route::middleware('rate.limit')->group(function () {
    Route::prefix('timeline')->group(function () {
        Route::get('/for-you', [TimelineController::class, 'forYou']);
        Route::get('/following', [TimelineController::class, 'following']);
    });
}); 