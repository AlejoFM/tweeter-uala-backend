<?php

declare(strict_types=1);

namespace src\Tweet\Domain\Repositories;

use src\Tweet\Domain\Models\Tweet;


interface EloquentFindByIdTweetRepositoryInterface
{
    public function findById(int $id): Tweet;
}




