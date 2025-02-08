<?php

declare(strict_types=1);

namespace Tests\Tweet\Unit\Domain\Models;

use DateTime;
use PHPUnit\Framework\TestCase;
use src\Tweet\Domain\Models\Tweet;
use src\Tweet\Domain\Exceptions\TweetContentTooLongException;
use src\Tweet\Domain\ValueObjects\TweetContent;
use src\User\Domain\Models\Entities\User;
use src\User\Domain\ValueObjects\UserId;


class TweetTest extends TestCase
{
    public function test_can_create_valid_tweet(): void
    {
        $tweet = Tweet::create(
            id: 1,
            userId: UserId::fromInt(1),
            content: TweetContent::fromString('Hello World'),
            createdAt: new DateTime(),
            user: new User(
                id: 1,
                username: 'John Doe'
            )
        );

        $this->assertEquals(1, $tweet->getUserId()->value());
        $this->assertEquals('Hello World', $tweet->getContent()->value());

    }

    public function test_cannot_create_tweet_with_long_content(): void
    {
        $this->expectException(TweetContentTooLongException::class);

        Tweet::create(
            id: 1,
            userId: UserId::fromInt(1),
            content: TweetContent::fromString(str_repeat('a', 281)),
            createdAt: new DateTime(),
            user: new User(
                id: 1,
                username: 'John Doe'
            )
        );

    }
} 