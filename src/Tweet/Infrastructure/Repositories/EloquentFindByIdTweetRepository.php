<?php

declare(strict_types=1);

namespace src\Tweet\Infrastructure\Repositories;

use src\Tweet\Domain\Models\Tweet;
use src\Tweet\Domain\Repositories\EloquentFindByIdTweetRepositoryInterface;
use src\Tweet\Domain\Exceptions\TweetNotFoundException;
use src\Tweet\Infrastructure\Persistence\Eloquent\TweetEloquentModel;
use src\User\Domain\ValueObjects\UserId;
use src\Tweet\Domain\ValueObjects\TweetContent;

class EloquentFindByIdTweetRepository implements EloquentFindByIdTweetRepositoryInterface
{
    public function findById(int $id): Tweet
    {
        $model = TweetEloquentModel::find($id);
        

        if (!$model) {
            throw TweetNotFoundException::withId($id);
        }

        return Tweet::fromPrimitives(
            $model->getId(),
            $model->getUserId(),
            $model->getContent(),
            $model->getCreatedAt(),
            $model->getDomainUser()
        );

    }
}

