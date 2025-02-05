<?php

use Illuminate\Support\Facades\Route;
use App\User\Presentation\HTTP\UserController;

Route::prefix('users')->group(function () {

    Route::get('{id}', [UserController::class, 'show']);
    
});