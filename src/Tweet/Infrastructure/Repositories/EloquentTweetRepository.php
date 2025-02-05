<?php

declare(strict_types=1);

namespace App\Tweet\Infrastructure\Repositories;

use App\Tweet\Domain\Models\Tweet;
use App\Tweet\Domain\Repositories\TweetRepositoryInterface;

class EloquentTweetRepository implements TweetRepositoryInterface
{
    public function create(int $userId, string $content): Tweet
    {
        $tweet = Tweet::create([
            'user_id' => $userId,
            'content' => $content,
        ]);

        return $this->toEntity($tweet);
    }

    public function findById(int $id): ?Tweet
    {
        $tweet = Tweet::find($id);
        return $tweet ? $this->toEntity($tweet) : null;
    }


    public function getTimelineByUserId(int $userId, ?string $cursor = null, int $limit = 20): array
    {
        $query = Tweet::where('user_id', $userId)
            ->orderBy('created_at', 'desc');


        if ($cursor) {
            $query->where('created_at', '<', base64_decode($cursor));
        }

        $tweets = $query->limit($limit + 1)->get();
        
        $hasMore = $tweets->count() > $limit;
        $tweets = $tweets->take($limit);
        
        return [
            'tweets' => $tweets->map(fn($tweet) => $this->toEntity($tweet))->toArray(),
            'next_cursor' => $hasMore ? base64_encode($tweets->last()->created_at) : null
        ];
    }

    private function toEntity(Tweet $model): Tweet
    {
        return new Tweet(
            id: $model->id,
            userId: $model->user_id,
            content: $model->content,
            createdAt: $model->created_at->toIso8601String()

        );
    }
} 