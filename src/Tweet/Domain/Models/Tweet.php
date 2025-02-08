<?php

declare(strict_types=1);

namespace src\Tweet\Domain\Models;

use DateTime;
use src\User\Domain\ValueObjects\UserId;
use src\Tweet\Domain\ValueObjects\TweetContent;
use src\User\Domain\Models\Entities\User;

class Tweet
{
    private function __construct(
        private readonly ?int $id,
        private readonly UserId $userId,
        private readonly TweetContent $content,
        private readonly DateTime $createdAt,
        private readonly User $user
    ) {}

    public static function create(int $id, UserId $userId, TweetContent $content, DateTime $createdAt, User $user): self
    {
        return new self(
            id: $id,
            userId: $userId,
            content: $content,
            createdAt: $createdAt,
            user: $user
        );
    }

    public static function fromPrimitives(int $id, int $userId, string $content, DateTime $createdAt, User $user): self
    {
        return new self(
            id: $id,
            userId: UserId::fromInt($userId),
            content: TweetContent::fromString($content),
            createdAt: $createdAt,
            user: $user
        );
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getContent(): TweetContent
    {
        return $this->content;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId->value(),
            'content' => $this->content->value(),
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s')
        ];
    }

    public function getUser(): User
    {
        return $this->user;
    }

} 