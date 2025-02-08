<?php

declare(strict_types=1);

namespace src\User\Domain\ValueObjects;

use src\User\Domain\Exceptions\InvalidUserIdException;

final class UserId
{
    private function __construct(
        private readonly int $value
    ) {
        $this->ensureIsValidUserId($value);
    }

    public static function fromInt(int $id): self
    {
        return new self($id);
    }

    private function ensureIsValidUserId(int $id): void
    {
        if ($id <= 0) {
            throw new InvalidUserIdException(
                '<' . $id . '> does not allow negative or zero values'
            );
        }
    }


    public function value(): int
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}
