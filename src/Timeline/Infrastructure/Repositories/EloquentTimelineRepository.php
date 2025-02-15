<?php

declare(strict_types=1);

namespace src\Timeline\Infrastructure\Repositories;

use src\Timeline\Domain\Repositories\TimelineRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class EloquentTimelineRepository implements TimelineRepositoryInterface
{
    public function getForYou(int $userId, ?string $cursor = null, int $limit = 20): array
    {
        $cacheKey = "timeline:for-you:{$userId}:{$cursor}:{$limit}";
        
        $cached = Redis::get($cacheKey);
        if ($cached) {
            return json_decode($cached, true);
        }

        $result = $this->getForYouFromDB($userId, $cursor, $limit);
        Redis::setex($cacheKey, 300, json_encode($result));
        
        return $result;
    }

    private function getForYouFromDB(int $userId, ?string $cursor = null, int $limit = 20): array
    {
        $query = DB::table('tweets')
            ->join('users', 'tweets.user_id', '=', 'users.id')
            ->select('tweets.*', 'users.username')
            ->orderBy('tweets.created_at', 'desc');

        if ($cursor) {
            $query->where('tweets.created_at', '<', base64_decode($cursor));
        }

        $tweets = $query->limit($limit + 1)->get();
        
        return $this->formatResponse($tweets, $limit);
    }

    public function getFollowing(int $userId, ?string $cursor = null, int $limit = 20): array
    {
        $cacheKey = "timeline:following:{$userId}:{$cursor}:{$limit}";
        
        $cached = Redis::get($cacheKey);
        if ($cached) {
            return json_decode($cached, true);
        }

        $result = $this->getFollowingFromDB($userId, $cursor, $limit);
        Redis::setex($cacheKey, 300, json_encode($result));
        
        return $result;
    }

    private function getFollowingFromDB(int $userId, ?string $cursor = null, int $limit = 20): array
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

        $tweets = $query->limit($limit + 1)->get();
        
        return $this->formatResponse($tweets, $limit);
    }

    private function formatResponse($tweets, int $limit): array
    {
        $hasMore = $tweets->count() > $limit;
        $tweets = $tweets->take($limit);
        
        return [
            'tweets' => $tweets->map(fn($tweet) => [
                'id' => $tweet->id,
                'content' => $tweet->content,
                'user' => [
                    'id' => $tweet->user_id,
                    'username' => $tweet->username
                ],
                'created_at' => $tweet->created_at
            ])->toArray(),
            'next_cursor' => $hasMore ? base64_encode($tweets->last()->created_at) : null
        ];
    }
}