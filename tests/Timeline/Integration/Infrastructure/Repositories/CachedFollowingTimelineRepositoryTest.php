<?php

declare(strict_types=1);

namespace Tests\Timeline\Integration\Infrastructure\Repositories;

use Tests\TestCase;
use src\Timeline\Infrastructure\Repositories\CachedFollowingTimelineRepository;
use src\Timeline\Infrastructure\Repositories\EloquentFollowingTimelineRepository;
use src\Tweet\Infrastructure\Persistence\Eloquent\TweetEloquentModel;
use src\User\Infrastructure\Persistence\UserEloquentModel;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;

class CachedFollowingTimelineRepositoryTest extends TestCase
{
    private CachedFollowingTimelineRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new CachedFollowingTimelineRepository(
            new EloquentFollowingTimelineRepository()
        );
        Redis::flushall();
    }

    public function test_caches_timeline_results(): void
    {
        // Arrange
        $follower = UserEloquentModel::factory()->create();
        $following = UserEloquentModel::factory()->create();

        // Create follow relationship
        DB::table('follows')->insert([
            'follower_id' => $follower->id,
            'following_id' => $following->id
        ]);

        $tweet = TweetEloquentModel::factory()
            ->forUser($following)
            ->create();

        // Act - First call should hit the database
        $firstResult = $this->repository->getFollowing($follower->id);
        
        // Create new tweet that shouldn't appear in cached result
        TweetEloquentModel::factory()
            ->forUser($following)
            ->create();

        // Second call should hit the cache
        $secondResult = $this->repository->getFollowing($follower->id);

        // Assert
        $this->assertNotEquals(
            json_decode(json_encode($firstResult), true),
            json_decode(json_encode($secondResult), true)
        );

        $this->assertCount(2, $secondResult['data']);
    }
} 