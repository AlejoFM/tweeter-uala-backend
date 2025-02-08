<?php

declare(strict_types=1);

namespace src\Tweet\Infrastructure\Repositories;

use Illuminate\Support\Facades\Log;
use src\Tweet\Domain\Models\Tweet;
use src\Tweet\Domain\Repositories\CreateTweetRepositoryInterface;
use src\Tweet\Infrastructure\Persistence\Eloquent\TweetEloquentModel;
use src\User\Domain\ValueObjects\UserId;
use src\Tweet\Domain\ValueObjects\TweetContent;
use src\User\Domain\Models\Entities\User;
use src\User\Infrastructure\Persistence\UserEloquentModel;

class EloquentCreateTweetRepository implements CreateTweetRepositoryInterface
{
    public function create(UserId $userId, TweetContent $content): Tweet
    {
        $model = TweetEloquentModel::create([
            'user_id' => $userId->value(),
            'content' => $content->value(),
            'created_at' => now()
        ]);

        $userModel = UserEloquentModel::find($userId->value());
        $user = new User(
            id: $userModel->id,
            username: $userModel->username,
        );

        Log::info('Tweet created from repository: ' . json_encode($model));
        return Tweet::create(
            id: $model->id,
            userId: UserId::fromInt($model->user_id),
            content: TweetContent::fromString($model->content),
            createdAt: $model->created_at,
            user: $user
        );
    }
}