<?php

namespace Tests\Integration\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use src\User\Infrastructure\Persistence\UserEloquentModel;
use src\User\Infrastructure\Repositories\EloquentUserFollowByIdRepository;

class UserFollowTest extends TestCase

{
    use RefreshDatabase;

    private EloquentUserFollowByIdRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new EloquentUserFollowByIdRepository();
    }

    /** @test */
    public function repository_can_follow_user(): void
    {
        // Arrange
        $user = UserEloquentModel::factory()->create();
        $userToFollow = UserEloquentModel::factory()->create();

        // Verificar que la relación no existe
        $this->assertDatabaseMissing('follows', [
            'follower_id' => $user->id,
            'following_id' => $userToFollow->id
        ]);

        // Act
        $result = $this->repository->followUserWithUserId($user->id, $userToFollow->id);

        // Assert
        $this->assertTrue($result);
        $this->assertDatabaseHas('follows', [
            'follower_id' => $user->id,
            'following_id' => $userToFollow->id
        ]);
    }
}