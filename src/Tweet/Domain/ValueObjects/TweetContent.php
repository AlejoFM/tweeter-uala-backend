<?php

declare(strict_types=1);

namespace src\Tweet\Domain\ValueObjects;

use src\Tweet\Domain\Exceptions\EmptyTweetContentException;
use src\Tweet\Domain\Exceptions\TweetContentTooLongException;

final class TweetContent
{
    private function __construct(
        private readonly string $value
    ) {
        $this->ensureIsNotEmpty($value);
        $this->ensureIsNotTooLong($value);
    }

    public static function fromString(string $content): self
    {
        return new self($content);
    }

    private function ensureIsNotEmpty(string $content): void
    {
        if (empty($content)) {
            throw new EmptyTweetContentException("Content cannot be empty");
        }
    }


    private function ensureIsNotTooLong(string $content): void
    {
        if (strlen($content) > 280) {
            throw new TweetContentTooLongException("Content cannot exceed 280 characters");
        }
    }


    public function value(): string
    {
        return $this->value;
    }
} 