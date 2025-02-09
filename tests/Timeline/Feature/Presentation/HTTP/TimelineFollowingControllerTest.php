<?php

declare(strict_types=1);

namespace Tests\Timeline\Feature\Presentation\HTTP;

use Tests\TestCase;
use src\Tweet\Infrastructure\Persistence\Eloquent\TweetEloquentModel;
use src\User\Infrastructure\Persistence\UserEloquentModel;
use Illuminate\Support\Facades\DB;

class TimelineFollowingControllerTest extends TestCase
{
    public function test_can_get_following_timeline(): void
    {
        // Arrange
        $follower = UserEloquentModel::factory()->create();
        $following = UserEloquentModel::factory()->create();

        DB::table('follows')->insert([
            'follower_id' => $follower->id,
            'following_id' => $following->id
        ]);

        $tweet = TweetEloquentModel::factory()
            ->forUser($following)
            ->withContent('Test tweet content')
            ->state([
                'created_at' => '2025-01-01 00:00:00',
                'updated_at' => '2025-01-01 00:00:00'
            ])
            ->create();

        // Act
        $response = $this->getJson("/api/timeline/following/{$follower->id}", [
            'X-User-Id' => $follower->id
        ]);

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'content',
                        'user' => [
                            'id',
                            'username'
                        ],
                        'created_at',
                        'updated_at'
                    ]
                ],
                'meta' => [
                    'cursor',
                    'has_more'
                ]
            ]);
    }

    public function test_returns_empty_timeline_when_not_following_anyone(): void
    {
        $user = UserEloquentModel::factory()->create();

        $response = $this->getJson("/api/timeline/following/{$user->id}", [
            'X-User-Id' => $user->id
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [],
                'meta' => [
                    'cursor' => [null, null],
                    'has_more' => [false, false]
                ],
                'message' => 'Following timeline retrieved successfully'
            ]);
    }
} 