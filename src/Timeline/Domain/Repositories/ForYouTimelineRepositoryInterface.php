<?php

declare(strict_types=1);

namespace src\Timeline\Domain\Repositories;

interface ForYouTimelineRepositoryInterface
{
    public function getForYou(int $userId, ?string $cursor = null, int $limit = 20): array;
} 