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

    /**
     * @OA\Get(
     *     path="/users/{id}",
     *     summary="Obtener un usuario por su ID",
     *     tags={"Usuarios"},
     *     @OA\Parameter(name="id", in="path", required=true, description="ID del usuario"),
     *     @OA\Response(response=200, description="Usuario encontrado"),
     *     @OA\Response(response=404, description="Usuario no encontrado"),
     *     security={{"userIdHeader":{}}}
     * )
     */
    public function show(int $id): JsonResponse
    {
        $user = $this->userRepository->findById($id);
        return response()->json(['data' => $user]);
    }

}