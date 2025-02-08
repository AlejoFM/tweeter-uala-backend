<?php

declare(strict_types=1);

namespace src\Tweet\Presentation\HTTP;

use src\Tweet\Domain\Repositories\EloquentFindByIdTweetRepositoryInterface;
use src\Tweet\Presentation\Resources\TweetResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class FindByIdTweetController
{
    public function __construct(
        private EloquentFindByIdTweetRepositoryInterface $repository

    ) {}

    public function __invoke(int $id): JsonResponse
    {
        $tweet = $this->repository->findById($id);
        Log::info('Tweet found:', [
            'tweet' => $tweet
        ]);
        Log::info('Tweet Resource :', [
            'tweet' => TweetResource::make($tweet)
        ]);
        return TweetResource::make($tweet)
            ->response()
            ->setStatusCode(200);


    }
}

