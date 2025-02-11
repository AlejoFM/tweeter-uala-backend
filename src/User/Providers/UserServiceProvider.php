<?php

declare(strict_types=1);

namespace src\User\Providers;

use Illuminate\Support\ServiceProvider;
use src\User\Domain\Repositories\UserFindByIdRepositoryInterface;
use src\User\Domain\Repositories\UserRepositoryInterface;
use src\User\Domain\Repositories\UserFollowByIdRepositoryInterface;
use src\User\Infrastructure\Repositories\EloquentUserFindByIdRepository;
use src\User\Infrastructure\Repositories\EloquentUserRepository;
use src\User\Infrastructure\Repositories\EloquentUserFollowByIdRepository;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserFollowByIdRepositoryInterface::class, EloquentUserFollowByIdRepository::class);
        $this->app->bind(UserFindByIdRepositoryInterface::class, EloquentUserFindByIdRepository::class);
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(
            __DIR__ . '/../Presentation/Routes/api.php'
        );
    }
} 