<?php

declare(strict_types=1);

namespace src\Tweet\Domain\Exceptions;

class InvalidTweetContentException extends \Exception
{
    public function __construct(string $message = 'Invalid tweet content', int $code = 400, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
