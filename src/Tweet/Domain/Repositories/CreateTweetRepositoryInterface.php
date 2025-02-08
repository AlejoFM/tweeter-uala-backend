<?php

declare(strict_types=1);

namespace src\Tweet\Domain\Repositories;

use src\Tweet\Domain\Models\Tweet;
use src\User\Domain\ValueObjects\UserId;
use src\Tweet\Domain\ValueObjects\TweetContent;

interface CreateTweetRepositoryInterface
{
    public function create(UserId $userId, TweetContent $content): Tweet;
}





