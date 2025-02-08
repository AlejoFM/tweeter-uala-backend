<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use src\Shared\Exceptions\RateLimitExceededException;
use Symfony\Component\HttpFoundation\Response;


class RateLimiter
{
    private const RATE_LIMIT = 100; // requests
    private const TIME_WINDOW = 60; // seconds

    private function getRateLimitForEndpoint(Request $request): array
    {
        $path = explode('/', trim($request->path(), '/'));
        $config = config('rate-limits');

        if (isset($path[0]) && isset($path[1]) && isset($config[$path[0]][$path[1]])) {
            return $config[$path[0]][$path[1]];
        }

        return [
            'limit' => self::RATE_LIMIT,
            'window' => self::TIME_WINDOW
        ];
    }

    public function handle(Request $request, Closure $next): Response
    {
        $userId = $request->attributes->get('userId');
        $endpointConfig = $this->getRateLimitForEndpoint($request);
        $key = "rate_limit:{$userId}:" . $this->getEndpointKey($request);

        $requests = Redis::incr($key);
        if ($requests === 1) {
            Redis::expire($key, $endpointConfig['window']);
        }

        if ($requests > $endpointConfig['limit']) {
            throw new RateLimitExceededException(
                retryAfter: Redis::ttl($key)
            );
        }

        $response = $next($request);

        return $response->withHeaders([
            'X-RateLimit-Limit' => $endpointConfig['limit'],
            'X-RateLimit-Remaining' => max(0, $endpointConfig['limit'] - $requests),
            'X-RateLimit-Reset' => Redis::ttl($key)
        ]);
    }

    private function getEndpointKey(Request $request): string
    {
        return md5($request->method() . ':' . $request->path());
    }
}