<?php

use Illuminate\Support\Facades\Route;
use App\Timeline\Presentation\HTTP\TimelineController;


Route::middleware('identify.user')->group(function () {
    Route::prefix('timeline')->group(function () {
        Route::get('/for-you', [TimelineController::class, 'forYou']);
        Route::get('/following', [TimelineController::class, 'following']);
    });
}); 