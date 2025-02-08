<?php

declare(strict_types=1);

namespace src\Tweet\Domain\Exceptions;

class InvalidCreatedAtException extends \Exception
{
    public function __construct(string $message = 'Invalid created at', int $code = 400, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
