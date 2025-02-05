<?php

use Illuminate\Support\Facades\Route;
use App\Tweet\Presentation\HTTP\TweetController;


Route::middleware('identify.user')->group(function () {
    Route::prefix('tweets')->group(function () {
        Route::post('/', [TweetController::class, 'store']);
        Route::get('/{id}', [TweetController::class, 'show']);
        Route::get('/timeline', [TweetController::class, 'timeline']);
    });
}); 