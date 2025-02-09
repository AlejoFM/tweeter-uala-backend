<?php

namespace src\User\Domain\Repositories;

use src\User\Domain\Models\Entities\User;

interface UserFindByIdRepositoryInterface

{
    public function findById(int $id): ?User;
}