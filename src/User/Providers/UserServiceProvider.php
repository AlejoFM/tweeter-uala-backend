<?php

declare(strict_types=1);

namespace src\User\Providers;

use Illuminate\Support\ServiceProvider;
use src\User\Domain\Repositories\UserRepositoryInterface;
use src\User\Infrastructure\Repositories\EloquentUserRepository;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(
            __DIR__ . '/../Infrastructure/Routes/api.php'
        );
    }
} 