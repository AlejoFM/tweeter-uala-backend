<?php

namespace src\User\Domain\Repositories;

interface UserFollowByIdRepositoryInterface
{
    public function followUserWithUserId(int $userId, int $followingId): bool;
}