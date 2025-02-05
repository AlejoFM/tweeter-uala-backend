<?php

declare(strict_types=1);

namespace App\User\Providers;

use Illuminate\Support\ServiceProvider;
use App\User\Domain\Repositories\UserRepositoryInterface;
use App\User\Infrastructure\Repositories\EloquentUserRepository;

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