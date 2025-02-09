<?php

declare(strict_types=1);

namespace src\Timeline\Domain\Repositories;

interface FollowingTimelineRepositoryInterface
{
    public function getFollowing(int $userId, ?string $cursor = null, int $limit = 20): array;
} 