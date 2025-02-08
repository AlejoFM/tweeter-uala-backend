<?php

declare(strict_types=1);

namespace tests\Unit\Tweet\Infrastructure\Repositories;

use Illuminate\Support\Facades\Log;
use src\Tweet\Domain\Exceptions\EmptyTweetContentException;
use src\Tweet\Domain\Exceptions\TweetContentTooLongException;
use src\Tweet\Domain\Models\Tweet;
use src\Tweet\Domain\ValueObjects\TweetContent;
use src\Tweet\Infrastructure\Repositories\EloquentCreateTweetRepository;
use src\User\Domain\Exceptions\InvalidUserIdException;
use src\User\Domain\ValueObjects\UserId;
use Tests\TestCase;
use src\Tweet\Domain\Exceptions\InvalidTweetContentException;

class EloquentCreateTweetRepositoryTest extends TestCase
{
    private EloquentCreateTweetRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new EloquentCreateTweetRepository();
    }

    public function test_persists_tweet_and_retrieves_it()
    {
        $userId = UserId::fromInt(1);
        $content = TweetContent::fromString('Hello, world!, this is a great tweet with a lot of characters and a lot of words because im very creative and i can write a lot of words');
        
        $tweet = $this->repository->create($userId, $content);
        

        $this->assertInstanceOf(Tweet::class, $tweet);
        $this->assertEquals(1, $tweet->getUserId()->value());

        $this->assertEquals('Hello, world!, this is a great tweet with a lot of characters and a lot of words because im very creative and i can write a lot of words', $tweet->getContent()->value());
    }

    public function test_persists_tweet_and_retrieves_it_with_less_than_280_characters()
    {
        $tweet = $this->repository->create(UserId::fromInt(1), TweetContent::fromString('Hello, world!, this is a short tweet'));

        $this->assertInstanceOf(Tweet::class, $tweet);
        $this->assertEquals(1, $tweet->getUserId()->value());
        $this->assertEquals('Hello, world!, this is a short tweet', $tweet->getContent()->value());
    }

    public function test_persists_tweet_and_fails_if_content_is_more_than_280_characters(): void
    {
        $this->expectException(TweetContentTooLongException::class);
        $this->expectExceptionMessage('Content cannot exceed 280 characters');

        $this->repository->create(
            userId: UserId::fromInt(1),
            content: TweetContent::fromString(str_repeat('a', 281))
        );
    }

    public function test_persists_tweet_and_fails_if_content_is_empty(): void
    {
        $this->expectException(EmptyTweetContentException::class);
        $this->expectExceptionMessage('Content cannot be empty');


        $this->repository->create(
            userId: UserId::fromInt(1),
            content: TweetContent::fromString('')
        );
    }

    public function test_persists_tweet_and_fails_if_user_id_is_negative()
    {
        $this->expectException(InvalidUserIdException::class);
        $this->expectExceptionMessage('<-1> does not allow negative or zero values');

        $this->repository->create(UserId::fromInt(-1), TweetContent::fromString('Hello, world!, this is a great tweet with a lot of characters and a lot of words because im very creative and i can write a lot of words'));
    }

    public function test_persists_tweet_and_fails_if_user_id_is_zero()
    {
        $this->expectException(InvalidUserIdException::class);
        $this->expectExceptionMessage('<0> does not allow negative or zero values');

        $this->repository->create(
            userId: UserId::fromInt(0),
            content: TweetContent::fromString('Hello, world!, this is a great tweet with a lot of characters and a lot of words because im very creative and i can write a lot of words')
        );
    }
}

