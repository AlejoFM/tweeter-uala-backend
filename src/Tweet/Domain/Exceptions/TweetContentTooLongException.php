<?php

declare(strict_types=1);

namespace src\Tweet\Domain\Exceptions;

class TweetContentTooLongException extends \Exception
{
    public function __construct(string $message = 'Tweet content is too long', int $code = 400, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
