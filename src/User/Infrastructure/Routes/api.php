<?php

use Illuminate\Support\Facades\Route;
use src\User\Presentation\HTTP\UserController;

Route::prefix('users')->group(function () {
    Route::get('{id}', [UserController::class, 'show']);
});