<?php

namespace App\Services\RequestLogging;

interface LoggerInterface
{
    public function log(string $msg) : void;
}
