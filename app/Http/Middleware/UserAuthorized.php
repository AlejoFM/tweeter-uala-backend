<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserAuthorized
{
    public function handle($request, Closure $next)
    {
        if (!$this->isUserAuthorized($request)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        return $next($request);
    }


    private function isUserAuthorized(Request $request): bool
    {
        return $request->header('X-User-Id') !== null;
    }
}
