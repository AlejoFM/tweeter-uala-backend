<?php

declare(strict_types=1);

namespace src\Timeline\Infrastructure\Repositories;

use src\Timeline\Domain\Repositories\ForYouTimelineRepositoryInterface;
use src\Tweet\Infrastructure\Persistence\Eloquent\TweetEloquentModel;
use Illuminate\Support\Facades\DB;

class EloquentForYouTimelineRepository implements ForYouTimelineRepositoryInterface
{
    public function getForYou(int $userId, ?string $cursor = null, int $limit = 20): array
    {
        $query = TweetEloquentModel::query()
            ->select([
                'tweets.id',
                'tweets.content',
                'tweets.user_id',
                'tweets.created_at',
                'tweets.updated_at',
                'users.username'
            ])
            ->join('users', 'users.id', '=', 'tweets.user_id')
            ->orderBy('tweets.created_at', 'desc')
            ->limit($limit);

        if ($cursor) {
            $query->whereDate('tweets.created_at', '<', base64_decode($cursor));
        }

        $tweets = $query->get();
        
        $nextCursor = $tweets->count() === $limit 
            ? base64_encode($tweets->last()->created_at->format('Y-m-d H:i:s'))
            : null;
        return [
            'data' => $tweets->toArray(),
            'meta' => [
                'cursor' => $nextCursor,
                'has_more' => $nextCursor !== null
            ]
        ];
    }
} 