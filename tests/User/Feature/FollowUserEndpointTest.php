<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use src\User\Infrastructure\Persistence\UserEloquentModel;

class FollowUserEndpointTest extends TestCase

{
    use RefreshDatabase;


    public function test_user_can_follow_another_user(): void
    {
        // Arrange
        $user = UserEloquentModel::factory()->create();
        $userToFollow = UserEloquentModel::factory()->create();


        // Act
        $response = $this->postJson("/api/users/{$user->id}/follow/{$userToFollow->id}", 
        [], 
        ['X-User-Id' => $user->id]);


        // Assert
        $response->assertStatus(200)
            ->assertJson(['message' => 'Followed successfully']);
    }

    public function test_user_cannot_follow_themselves(): void
    {
        // Arrange
        $user = UserEloquentModel::factory()->create();

        // Act
        $response = $this->postJson("/api/users/{$user->id}/follow/{$user->id}", 
        [], 
        ['X-User-Id' => $user->id]);


        // Assert
        $response->assertStatus(422);
    }

    public function test_cannot_follow_nonexistent_user(): void
    {
        // Arrange
        $user = UserEloquentModel::factory()->create();
        $nonexistentId = 99999;


        // Act
        $response = $this->postJson("/api/users/{$user->id}/follow/{$nonexistentId}", 
        [], 
        ['X-User-Id' => $user->id]);


        // Assert
        $response->assertStatus(422);
    }
}