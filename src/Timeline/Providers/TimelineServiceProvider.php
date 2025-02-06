<?php

declare(strict_types=1);

namespace src\Timeline\Providers;

use Illuminate\Support\ServiceProvider;
use src\Timeline\Domain\Repositories\TimelineRepositoryInterface;
use src\Timeline\Infrastructure\Repositories\EloquentTimelineRepository;

class TimelineServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TimelineRepositoryInterface::class, EloquentTimelineRepository::class);
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(
            __DIR__ . '/../Infrastructure/Routes/api.php'
        );
    }
} 