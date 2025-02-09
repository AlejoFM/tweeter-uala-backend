<?php

declare(strict_types=1);

namespace src\Timeline\Infrastructure\Repositories;

use src\Timeline\Domain\Repositories\FollowingTimelineRepositoryInterface;
use Illuminate\Support\Facades\Redis;

class CachedFollowingTimelineRepository implements FollowingTimelineRepositoryInterface
{
    private const CACHE_TTL = 300;

    public function __construct(
        private FollowingTimelineRepositoryInterface $repository
    ) {}

    public function getFollowing(int $userId, ?string $cursor = null, int $limit = 20): array
    {
        $cacheKey = "timeline:following:{$userId}:{$cursor}:{$limit}";
        
        $cached = Redis::get($cacheKey);
        if ($cached) {
            return json_decode($cached, true);
        }

        $result = $this->repository->getFollowing($userId, $cursor, $limit);
        Redis::setex($cacheKey, self::CACHE_TTL, json_encode($result));
        
        return $result;
    }
} 