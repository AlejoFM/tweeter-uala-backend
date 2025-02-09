<?php

declare(strict_types=1);

namespace src\Timeline\Infrastructure\Repositories;

use src\Timeline\Domain\Repositories\FollowingTimelineRepositoryInterface;
use Illuminate\Support\Facades\DB;

class EloquentFollowingTimelineRepository implements FollowingTimelineRepositoryInterface
{
    public function getFollowing(int $userId, ?string $cursor = null, int $limit = 20): array
    {
        $tweets = $this->buildQuery($userId, $cursor, $limit)
            ->limit($limit + 1)
            ->get();

        return $this->formatResponse($tweets, $limit);
    }

    private function buildQuery(int $userId, ?string $cursor = null, int $limit = 20)
    {
        $query = DB::table('tweets')
            ->join('users', 'tweets.user_id', '=', 'users.id')
            ->join('follows', 'tweets.user_id', '=', 'follows.following_id')
            ->where('follows.follower_id', $userId)
            ->select('tweets.*', 'users.username')
            ->orderBy('tweets.created_at', 'desc');

        if ($cursor) {
            $query->where('tweets.created_at', '<', base64_decode($cursor));
        }

        return $query;
    }

    private function formatResponse($tweets, int $limit): array
    {
        $hasMore = $tweets->count() > $limit;
        $tweets = $tweets->take($limit);
        
        return [
            'data' => $tweets->toArray(),
            'cursor' => $hasMore ? base64_encode($tweets->last()->created_at) : null,
            'has_more' => $hasMore
        ];
    }
} 