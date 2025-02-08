<?php

declare(strict_types=1);

namespace Tests\Tweet\Unit\Infrastructure\Repositories;

use Tests\TestCase;
use src\Tweet\Infrastructure\Repositories\EloquentFindByIdTweetRepository;
use src\Tweet\Domain\Exceptions\TweetNotFoundException;
use src\Tweet\Infrastructure\Persistence\Eloquent\TweetEloquentModel;
use src\Tweet\Domain\ValueObjects\TweetContent;
use src\User\Domain\ValueObjects\UserId;

class EloquentFindByIdTweetRepositoryTest extends TestCase
{
    private EloquentFindByIdTweetRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new EloquentFindByIdTweetRepository();
    }

    public function test_finds_tweet_by_id(): void
    {
        $tweet = TweetEloquentModel::create([
            'user_id' => 1,
            'content' => 'Hello World',
            'created_at' => now()
        ]);

        $result = $this->repository->findById($tweet->id);

        $this->assertEquals($tweet->id, $result->getId());
        $this->assertEquals($tweet->content, $result->getContent()->value());
    }

    public function test_throws_exception_when_tweet_not_found(): void
    {
        $this->expectException(TweetNotFoundException::class);
        $this->expectExceptionMessage('Tweet with id <999> not found');

        $this->repository->findById(999);
    }
}
