<?php

declare(strict_types=1);

namespace src\Tweet\Domain\Exceptions;

class EmptyTweetContentException extends \Exception
{
    public function __construct(string $message = 'Tweet content cannot be empty', int $code = 400, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
