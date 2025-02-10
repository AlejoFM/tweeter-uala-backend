<?php

declare(strict_types=1);

namespace src\Tweet\Presentation\HTTP;

use App\Http\Controllers\Controller;
use src\Tweet\Domain\Repositories\CreateTweetRepositoryInterface;
use Illuminate\Http\JsonResponse;
use src\Tweet\App\FormRequests\CreateTweetFormRequest;
use src\Tweet\Domain\ValueObjects\TweetContent;
use src\User\Domain\ValueObjects\UserId;
use src\Tweet\Presentation\Resources\TweetResource;




class CreateTweetController extends Controller
{
    public function __construct(
        private CreateTweetRepositoryInterface $repository
    ) {}

    /**
     * @OA\Post(
     *     path="/api/tweets",
     *     tags={"Tweets"},
     *     summary="Create a new tweet",
     *     description="Creates a new tweet for the authenticated user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"content"},
     *             @OA\Property(property="content", type="string", maxLength=280),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tweet created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="content", type="string"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="created_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\SecurityScheme(
     *         securityScheme="userIdHeader",
     *         type="apiKey",
     *         name="X-User-Id",
     *         in="header"
     *     ),
     *     security={{"userIdHeader": {}}}
     * )
     */


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