<?php

namespace src\Shared\Exceptions;

use Exception;

class RateLimitExceededException extends Exception
{
    public function __construct(
        public int $retryAfter = 60,
        $message = "Rate limit exceeded",
        $code = 429,
        Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

}


