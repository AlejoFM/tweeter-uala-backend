<?php

namespace src\User\Domain\Exceptions;

class FailedToFollowUserException extends \Exception
{
    public function __construct($message = 'Failed to follow user', $code = 500)
    {
        parent::__construct($message, $code);
    }


}