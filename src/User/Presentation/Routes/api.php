<?php

use Illuminate\Support\Facades\Route;
use src\User\Presentation\HTTP\UserFindByIdController;
use src\User\Presentation\HTTP\UserFollowByIdController;

Route::prefix('users')->group(function () {
    Route::get('/{id}', [UserFindByIdController::class, 'findById']);
    Route::post('/{userId}/follow/{followingId}', [UserFollowByIdController::class, 'followUserWithUserId']);
});