<?php

declare(strict_types=1);

namespace src\Tweet\Presentation\HTTP;

use src\Tweet\Domain\Repositories\CreateTweetRepositoryInterface;
use Illuminate\Http\JsonResponse;
use src\Tweet\App\FormRequests\CreateTweetFormRequest;
use src\Tweet\Domain\ValueObjects\TweetContent;
use src\User\Domain\ValueObjects\UserId;
use src\Tweet\Presentation\Resources\TweetResource;




class CreateTweetController
{
    public function __construct(
        private CreateTweetRepositoryInterface $repository
    ) {}

    public function __invoke(CreateTweetFormRequest $request): JsonResponse
    {
        $tweet = $this->repository->create(
            userId: UserId::fromInt($request->userId()),
            content: TweetContent::fromString($request->content())
        );


        return TweetResource::make($tweet)
            ->response()
            ->setStatusCode(201);
    }
}