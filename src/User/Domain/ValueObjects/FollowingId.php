<?php

namespace src\User\Domain\ValueObjects;

use src\Shared\Domain\ValueObjects\IntegerValueObject;

class FollowingId extends IntegerValueObject
{
    public function __construct(int $value)
    {

        parent::__construct($value);
    }

}