<?php

use Illuminate\Support\Facades\Route;
use src\Tweet\Presentation\HTTP\CreateTweetController;
use src\Tweet\Presentation\HTTP\FindByIdTweetController;


Route::prefix('tweets')->group(function () {
    Route::post('/', [CreateTweetController::class, '__invoke']);
    Route::get('/{id}', [FindByIdTweetController::class, '__invoke']);
});
