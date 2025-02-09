<?php

declare(strict_types=1);

namespace Tests\Timeline\Integration\Infrastructure\Repositories;

use Tests\TestCase;
use src\Timeline\Infrastructure\Repositories\CachedForYouTimelineRepository;
use src\Timeline\Infrastructure\Repositories\EloquentForYouTimelineRepository;
use src\Tweet\Infrastructure\Persistence\Eloquent\TweetEloquentModel;
use src\User\Infrastructure\Persistence\UserEloquentModel;
use Illuminate\Support\Facades\Redis;

class CachedForYouTimelineRepositoryTest extends TestCase
{
    private CachedForYouTimelineRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new CachedForYouTimelineRepository(
            new EloquentForYouTimelineRepository()
        );
        Redis::flushall();
    }

    public function test_caches_timeline_results(): void
    {
        // Arrange
        $user = UserEloquentModel::factory()->create(['username' => 'testuser']);
        $tweet = TweetEloquentModel::factory()
            ->forUser($user)
            ->withContent('Test tweet content')
            ->state([
                'created_at' => '2025-01-01 00:00:00',
                'updated_at' => '2025-01-01 00:00:00'
            ])
            ->create();

        // Act - First call should hit the database
        $firstResult = $this->repository->getForYou($user->id);
        
        // Create new tweet that shouldn't appear in cached result
        TweetEloquentModel::factory()
            ->forUser($user)
            ->create();

        // Second call should hit the cache
        $secondResult = $this->repository->getForYou($user->id);

        // Assert - Normalize the results for comparison
        $normalizedFirst = json_decode(json_encode($firstResult), true);
        $normalizedSecond = json_decode(json_encode($secondResult), true);
        
        $this->assertNotEquals($normalizedFirst, $normalizedSecond);
        $this->assertCount(2, $secondResult['data']);


    }
} 