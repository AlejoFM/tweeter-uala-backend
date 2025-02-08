<?php

declare(strict_types=1);

namespace src\User\Domain\Exceptions;

class InvalidUserIdException extends \Exception
{
    public function __construct(string $message = 'The user id is not an integer', int $code = 400, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

