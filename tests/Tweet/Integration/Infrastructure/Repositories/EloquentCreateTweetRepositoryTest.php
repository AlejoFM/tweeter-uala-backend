<?php

declare(strict_types=1);

namespace Tests\Tweet\Integration\Infrastructure\Repositories;

use Tests\TestCase;
use src\Tweet\Infrastructure\Repositories\EloquentCreateTweetRepository;
use src\Tweet\Domain\ValueObjects\TweetContent;
use src\User\Domain\ValueObjects\UserId;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EloquentCreateTweetRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private EloquentCreateTweetRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new EloquentCreateTweetRepository();
    }

    public function test_creates_tweet_in_database(): void
    {
        $userId = UserId::fromInt(1);
        $content = TweetContent::fromString('Hello World');

        $tweet = $this->repository->create($userId, $content);

        $this->assertDatabaseHas('tweets', [
            'user_id' => $userId->value(),
            'content' => $content->value()
        ]);
    }
} 