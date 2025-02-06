<?php
declare(strict_types=1);

namespace src\User\Domain\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class User extends Model
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
}
