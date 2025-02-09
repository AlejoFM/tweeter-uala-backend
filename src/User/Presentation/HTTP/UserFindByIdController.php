<?php

namespace src\User\Presentation\HTTP;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use src\User\Domain\Repositories\UserFindByIdRepositoryInterface;
use src\User\Presentation\Resources\UserResource;

class UserFindByIdController extends Controller
{
    public function __construct(
        private UserFindByIdRepositoryInterface $userFindByIdRepository
    ) {}

    /**
     * @OA\Get(
     *     path="/users/{id}",
     *     summary="Get a user by their ID",
     *     tags={"Users"},
     *     @OA\Parameter(name="id", in="path", required=true, description="ID of the user to retrieve"),
     *     @OA\Response(response=200, description="User found"),
     *     @OA\Response(response=404, description="User not found"),
     *     security={{"userIdHeader":{}}}
     * )
     */
    public function findById(int $id): JsonResponse

    {
        $user = $this->userFindByIdRepository->findById($id);
        return UserResource::make($user)
            ->response()
            ->setStatusCode(200);
    }
    
    

}