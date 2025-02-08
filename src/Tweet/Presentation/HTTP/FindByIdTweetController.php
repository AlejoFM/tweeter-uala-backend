<?php

declare(strict_types=1);

namespace src\Tweet\Presentation\HTTP;

use App\Http\Controllers\Controller;
use src\Tweet\Domain\Repositories\EloquentFindByIdTweetRepositoryInterface;
use src\Tweet\Presentation\Resources\TweetResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class FindByIdTweetController extends Controller
{
    public function __construct(
        private EloquentFindByIdTweetRepositoryInterface $repository

    ) {}

    /**
     * @OA\Get(
     *     path="/tweets/{id}",
     *     summary="Obtener un tweet por su ID",
     *     tags={"Tweets"},
     *     @OA\Parameter(name="id", in="path", required=true, description="ID del tweet"),
     *     @OA\Response(response=200, description="Tweet encontrado"),
     *     @OA\Response(response=404, description="Tweet no encontrado"),
     *     security={{"userIdHeader":{}}}
     * )
     */

    public function __invoke(int $id): JsonResponse
    {
        $tweet = $this->repository->findById($id);

        return TweetResource::make($tweet)
            ->response()
            ->setStatusCode(200);


    }
}

