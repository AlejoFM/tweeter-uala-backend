<?php

declare(strict_types=1);

namespace Tests\Timeline\Unit\Infrastructure\Repositories;

use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use src\Timeline\Infrastructure\Repositories\EloquentForYouTimelineRepository;
use src\Tweet\Infrastructure\Persistence\Eloquent\TweetEloquentModel;
use src\User\Infrastructure\Persistence\UserEloquentModel;

class EloquentForYouTimelineRepositoryTest extends TestCase
{
    private EloquentForYouTimelineRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new EloquentForYouTimelineRepository();
    }

    public function test_get_for_you_returns_tweets_in_correct_format(): void
    {
        // Arrange
        $user = UserEloquentModel::factory()->create();
        TweetEloquentModel::factory()->count(3)->create([
            'user_id' => $user->id
        ]);

        // Act
        $result = $this->repository->getForYou($user->id);
        // Assert
        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('meta', $result);
        $this->assertArrayHasKey('cursor', $result['meta']);
        $this->assertArrayHasKey('has_more', $result['meta']);
        $this->assertCount(3, $result['data']);
    }

    public function test_get_for_you_respects_limit(): void
    {
        // Arrange
        $user = UserEloquentModel::factory()->create();
        TweetEloquentModel::factory()->count(5)->create([
            'user_id' => $user->id
        ]);

        // Act
        $result = $this->repository->getForYou($user->id, null, 2);

        // Assert
        $this->assertCount(2, $result['data']);
        $this->assertTrue($result['meta']['has_more']);
    }

    public function test_get_for_you_uses_cursor_correctly(): void
    {
        // Arrange
        $user = UserEloquentModel::factory()->create();
        $tweets = TweetEloquentModel::factory()->count(3)->create([
            'user_id' => $user->id
        ]);
        $cursor = base64_encode($tweets[1]->created_at->format('Y-m-d H:i:s'));


        // Act
        $result = $this->repository->getForYou($user->id, $cursor);
        // Assert
        $this->assertCount(3, $result['data']);
        $this->assertEquals($tweets[2]->id, $result['data'][0]['id']);
        $this->assertEquals($tweets[1]->id, $result['data'][1]['id']);

        $this->assertEquals($tweets[0]->id, $result['data'][2]['id']);
    }
} 