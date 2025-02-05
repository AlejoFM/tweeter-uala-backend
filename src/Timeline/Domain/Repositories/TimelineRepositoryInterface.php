<?php

declare(strict_types=1);

namespace App\Timeline\Domain\Repositories;

interface TimelineRepositoryInterface

{
    public function getForYou(int $userId, ?string $cursor = null, int $limit = 20): array;
    public function getFollowing(int $userId, ?string $cursor = null, int $limit = 20): array;
} 