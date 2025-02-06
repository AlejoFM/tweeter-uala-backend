<?php

declare(strict_types=1);

namespace src\User\Domain\Repositories;

use src\User\Domain\Models\Entities\User;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;
    public function exists(int $id): bool;
} 