<?php

namespace src\User\Infrastructure\Repositories;

use Illuminate\Support\Facades\Log;
use src\User\Domain\Exceptions\FailedToFollowUserException;
use src\User\Domain\Repositories\UserFollowByIdRepositoryInterface;
use src\User\Infrastructure\Persistence\UserEloquentModel;

class EloquentUserFollowByIdRepository implements UserFollowByIdRepositoryInterface
{
    public function followUserWithUserId(int $userId, int $followingId): bool
    {
        try {
            $user = UserEloquentModel::find($userId);
            $following = UserEloquentModel::find($followingId);
            if ($user->following()->where('following_id', $followingId)->exists()) {

            throw new FailedToFollowUserException('User already follows this user', 400);
        }
        $user->following()->attach($following);
        $user->save();
        return true;
        } catch (\Exception $e) {
            Log::error('Error following user: ' . $e->getMessage());
            throw new FailedToFollowUserException('Error following user: ' . $e->getMessage(), 500);
        }
    }
}
