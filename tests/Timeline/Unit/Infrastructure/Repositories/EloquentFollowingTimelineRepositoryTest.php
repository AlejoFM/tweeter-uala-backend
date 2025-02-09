<?php

declare(strict_types=1);

namespace Tests\Timeline\Unit\Infrastructure\Repositories;

use Tests\TestCase;
use src\Timeline\Infrastructure\Repositories\EloquentFollowingTimelineRepository;
use src\Tweet\Infrastructure\Persistence\Eloquent\TweetEloquentModel;
use src\User\Infrastructure\Persistence\UserEloquentModel;
use Illuminate\Support\Facades\DB;

class EloquentFollowingTimelineRepositoryTest extends TestCase
{
    private EloquentFollowingTimelineRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new EloquentFollowingTimelineRepository();
    }

    public function test_get_following_returns_only_followed_users_tweets(): void
    {
        // Arrange
        $follower = UserEloquentModel::factory()->create();
        $following = UserEloquentModel::factory()->create();
        $notFollowing = UserEloquentModel::factory()->create();

        DB::table('follows')->insert([
            'follower_id' => $follower->id,
            'following_id' => $following->id
        ]);

        TweetEloquentModel::factory()->create(['user_id' => $following->id]);
        TweetEloquentModel::factory()->create(['user_id' => $notFollowing->id]);

        // Act
        $result = $this->repository->getFollowing($follower->id);

        // Assert
        $this->assertCount(1, $result['data']);
        $this->assertEquals($following->id, $result['data'][0]->user_id);
    }

    public function test_get_following_respects_limit(): void
    {
        // Arrange
        $follower = UserEloquentModel::factory()->create();
        $following = UserEloquentModel::factory()->create();

        DB::table('follows')->insert([
            'follower_id' => $follower->id,
            'following_id' => $following->id
        ]);

        TweetEloquentModel::factory()->count(5)->create(['user_id' => $following->id]);

        // Act
        $result = $this->repository->getFollowing($follower->id, null, 2);

        // Assert
        $this->assertCount(2, $result['data']);
        $this->assertTrue($result['has_more']);
    }
} 