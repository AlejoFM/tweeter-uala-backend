<?php

declare(strict_types=1);

namespace src\Tweet\Domain\Exceptions;

use DomainException;

final class TweetNotFoundException extends DomainException
{
    public static function withId(int $id): self
    {
        return new self('Tweet with id <' . $id . '> not found');
    }
} 