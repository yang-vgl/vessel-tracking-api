<?php

namespace App\Services\RequestLogging;

use Illuminate\Support\Facades\Redis;

class RedisLogger implements LoggerInterface
{
    private const REQUEST_LOG_KEY = 'request-log';

    public function log($msg) : void
    {
        Redis::lpush(self::REQUEST_LOG_KEY, $msg);
    }
}
