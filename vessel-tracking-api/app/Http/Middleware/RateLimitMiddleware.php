<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RateLimitMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $executed = RateLimiter::attempt(
            'send-message:' . $request->ip(),
            config('rateLimiter.max_attempts'),
            function () {
            },
            config('rateLimiter.decay_seconds'),
        );

        if ($executed === false) {
            return response()->json(['message' => 'Rate limit exceeded.'], Response::HTTP_TOO_MANY_REQUESTS);
        }

        return $next($request);
    }
}
