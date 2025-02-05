<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Repositories;

use App\User\Domain\Models\Entities\User;

use App\User\Domain\Repositories\UserRepositoryInterface;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function findById(int $id): ?User
    {
        $user = User::find($id);
        return $user ? $this->toEntity($user) : null;
    }


    public function exists(int $id): bool
    {
        return User::query()->where('id', $id)->exists();
    }


    private function toEntity(User $model): User
    {
        return new User(
            id: $model->id,
            username: $model->username
        );
    }

} 