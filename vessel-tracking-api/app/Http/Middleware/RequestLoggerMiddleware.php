<?php

namespace App\Http\Middleware;

use App\Services\RequestLogging\LoggerInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestLoggerMiddleware
{
    public function __construct(
        private readonly LoggerInterface $logger,
    ) {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $msg = [
            'ip' => $request->ip(),
            'body' =>  $request->all(),
            'url ' => $request->getRequestUri(),
        ];

        $this->logger->log(json_encode($msg));

        return $next($request);
    }
}
