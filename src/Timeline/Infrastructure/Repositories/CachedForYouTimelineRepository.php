<?php

declare(strict_types=1);

namespace src\Timeline\Infrastructure\Repositories;

use src\Timeline\Domain\Repositories\ForYouTimelineRepositoryInterface;
use Illuminate\Support\Facades\Redis;

class CachedForYouTimelineRepository implements ForYouTimelineRepositoryInterface
{
    private const CACHE_TTL = 300; // 5 minutes

    public function __construct(
        private ForYouTimelineRepositoryInterface $repository
    ) {}

    public function getForYou(int $userId, ?string $cursor = null, int $limit = 20): array
    {
        $cacheKey = "timeline:for-you:{$userId}:{$cursor}:{$limit}";
        
        $cached = Redis::get($cacheKey);
        if ($cached !== null) {
            return json_decode($cached, true);
        }

        $result = $this->repository->getForYou($userId, $cursor, $limit);
        
        // Asegurarnos de que meta.cursor y meta.has_more sean valores simples
        if (isset($result['meta']['cursor']) && is_array($result['meta']['cursor'])) {
            $result['meta']['cursor'] = $result['meta']['cursor'][0] ?? null;
        }
        if (isset($result['meta']['has_more']) && is_array($result['meta']['has_more'])) {
            $result['meta']['has_more'] = $result['meta']['has_more'][0] ?? false;
        }

        Redis::setex($cacheKey, self::CACHE_TTL, json_encode($result));
        
        return $result;
    }
} 