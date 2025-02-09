<?php

namespace Tests\Unit\User;

use Tests\TestCase;
use Mockery;
use src\User\App\FormRequests\FollowUserByIdFormRequest;
use src\User\Domain\Repositories\UserFollowByIdRepositoryInterface;
use src\User\Domain\Exceptions\FailedToFollowUserException;
use src\User\Presentation\HTTP\UserFollowByIdController;

class UserFollowByIdControllerTest extends TestCase
{
    private UserFollowByIdRepositoryInterface $repository;
    private UserFollowByIdController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(UserFollowByIdRepositoryInterface::class);
        $this->controller = new UserFollowByIdController($this->repository);
    }

    public function test_controller_calls_repository_with_correct_parameters(): void
    {
        // Arrange
        $request = $this->mockRequest(1, 2);
        
        $this->repository
            ->shouldReceive('followUserWithUserId')
            ->once()
            ->with(1, 2)
            ->andReturn(true);

        // Act
        $response = $this->controller->followUserWithUserId($request);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_controller_throws_exception_when_repository_fails(): void
    {
        // Arrange
        $request = $this->mockRequest(1, 2);
        
        $this->repository
            ->shouldReceive('followUserWithUserId')
            ->once()
            ->andReturn(false);

        // Assert
        $this->expectException(FailedToFollowUserException::class);

        // Act
        $this->controller->followUserWithUserId($request);
    }

    private function mockRequest(int $userId, int $followingId): FollowUserByIdFormRequest
    {
        $request = Mockery::mock(FollowUserByIdFormRequest::class);
        $request->userId = $userId;
        $request->followingId = $followingId;
        return $request;
    }
}