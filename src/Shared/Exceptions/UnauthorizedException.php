<?php
declare(strict_types=1);

namespace src\Shared\Exceptions;

use Exception;

class UnauthorizedException extends Exception
{
    public function __construct($message = "Unauthorized", $code = 401, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
