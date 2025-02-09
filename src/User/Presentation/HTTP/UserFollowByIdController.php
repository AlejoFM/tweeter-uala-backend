<?php

namespace src\User\Presentation\HTTP;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use src\User\App\FormRequests\FollowUserByIdFormRequest;
use src\User\Domain\Exceptions\FailedToFollowUserException;
use src\User\Domain\Repositories\UserFollowByIdRepositoryInterface;

class UserFollowByIdController extends Controller
{
    public function __construct(
        private UserFollowByIdRepositoryInterface $userFollowByIdRepository
    ) {}

    /**
     * @OA\Post(
     *     path="/api/users/{userId}/follow/{followingId}",
     *     summary="Follow a user by their ID",
     *     tags={"Users"},
     *     @OA\Parameter(name="userId", in="path", required=true, description="ID of the user to follow"),
     *     @OA\Parameter(name="followingId", in="path", required=true, description="ID of the user to follow"),
     *     @OA\Response(response=200, description="Followed successfully"),
     *     @OA\Response(response=404, description="User not found"),
     *     security={{"userIdHeader":{}}}
     * )
     */
    public function followUserWithUserId(FollowUserByIdFormRequest $request): JsonResponse
    {
        try {
            $result = $this->userFollowByIdRepository->followUserWithUserId($request->userId, $request->followingId);
            if (!$result) {
                throw new FailedToFollowUserException();
        }
        return response()->json(['message' => 'Followed successfully'], 200);
        } catch (\Exception $e) {
            throw new FailedToFollowUserException('Error following user: ' . $e->getMessage(), 500);
        }


    }


}