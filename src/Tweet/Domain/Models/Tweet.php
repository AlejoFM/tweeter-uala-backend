<?php

declare(strict_types=1);

namespace App\Tweet\Domain\Models;

use Illuminate\Database\Eloquent\Model;


class Tweet extends Model
{
    public function __construct(
        private readonly ?int $id,
        private readonly int $userId,
        private readonly string $content,
        private readonly string $createdAt
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
} 