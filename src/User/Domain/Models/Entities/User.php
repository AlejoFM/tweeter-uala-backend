<?php
declare(strict_types=1);

namespace src\User\Domain\Models\Entities;


class User
{
    public function __construct(
        private readonly int $id,
        private readonly string $username
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public static function fromPrimitives(int $id, string $username): self
    {
        return new self($id, $username);
    }
}
