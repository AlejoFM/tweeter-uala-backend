<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use src\Shared\Exceptions\UnauthorizedException;
use src\User\Infrastructure\Persistence\UserEloquentModel;


class UserAuthorized
{
    public function handle($request, Closure $next)
    {
        try {
            if (!$this->isUserAuthorized($request)) {
                throw new UnauthorizedException('Usuario no autenticado');
            }

            $user = $this->getUserFromRequest($request);
            if (!$user) {
                throw new UnauthorizedException('Usuario no encontrado');
            }

            return $next($request);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function isUserAuthorized(Request $request): bool
    {
        return $request->header('X-User-Id') !== null;
    }

    private function getUserFromRequest(Request $request): ?UserEloquentModel
    {
        return UserEloquentModel::find($request->header('X-User-Id'));
    }
}
