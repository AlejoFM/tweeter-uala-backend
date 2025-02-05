<?php

declare(strict_types=1);

namespace App\Tweet\Domain\Repositories;

use App\Tweet\Domain\Models\Tweet;


interface TweetRepositoryInterface
{
    public function create(int $userId, string $content): Tweet;
    public function findById(int $id): ?Tweet;
    public function getTimelineByUserId(int $userId, ?string $cursor = null, int $limit = 20): array;
} 