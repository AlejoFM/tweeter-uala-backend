<?php

namespace src\User\Infrastructure\Repositories;

use src\User\Domain\Models\Entities\User;
use src\User\Domain\Repositories\UserFindByIdRepositoryInterface;
use src\User\Infrastructure\Persistence\UserEloquentModel;

class EloquentUserFindByIdRepository implements UserFindByIdRepositoryInterface
{
    public function findById(int $id): ?User
    {
        $user = UserEloquentModel::find($id);
        return $user ? $this->toEntity($user) : null;
    }
    private function toEntity(UserEloquentModel $model): User
    {
        return new User(
            id: $model->id,
            username: $model->username
        );
    }
}
