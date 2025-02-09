<?php

namespace src\User\App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueFollowRule implements ValidationRule
{
    private int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (DB::table('follows')
            ->where('follower_id', $this->userId)
            ->where('following_id', $value)
            ->exists()
        ) {
            $fail('You are already following this user.');
        }
    }
}