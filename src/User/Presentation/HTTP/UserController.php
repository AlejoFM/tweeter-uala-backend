<?php

declare(strict_types=1);

namespace src\User\Presentation\HTTP;

use App\Http\Controllers\Controller;
use src\User\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;

class UserController extends Controller

{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function show(int $id): JsonResponse
    {
        $user = $this->userRepository->findById($id);
        return response()->json(['data' => $user]);
    }

}