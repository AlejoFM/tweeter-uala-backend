<?php

declare(strict_types=1);

namespace Tests\Timeline\Feature\Presentation\HTTP;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use src\Tweet\Infrastructure\Persistence\Eloquent\TweetEloquentModel;
use src\User\Infrastructure\Persistence\UserEloquentModel;

class TimelineForYouControllerTest extends TestCase
{
    public function test_can_get_for_you_timeline(): void
    {
        // Arrange
        $user = UserEloquentModel::factory()->create();
        $tweets = TweetEloquentModel::factory()
            ->count(3)
            ->forUser($user)
            ->create();

        // Act
        $response = $this->getJson('/api/timeline/for-you', [
            'X-User-Id' => $user->id
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
        
        $this->assertCount(3, $response->json('data'));
    }

    public function test_returns_unauthorized_without_user_id(): void
    {
        $response = $this->getJson('/api/timeline/for-you');
        
        $response->assertStatus(401);
    }
} 