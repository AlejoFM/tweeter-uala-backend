<?php

declare(strict_types=1);

namespace src\User\Infrastructure\Persistence\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use src\User\Infrastructure\Persistence\UserEloquentModel;

class UserEloquentModelFactory extends Factory
{
    protected $model = UserEloquentModel::class;

    public function definition(): array
    {
        return [
            'username' => $this->faker->userName(),
        ];
    }
} 