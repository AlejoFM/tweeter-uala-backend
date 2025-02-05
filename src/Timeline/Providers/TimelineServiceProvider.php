<?php

declare(strict_types=1);

namespace App\Timeline\Providers;

use Illuminate\Support\ServiceProvider;
use App\Timeline\Domain\Repositories\TimelineRepositoryInterface;
use App\Timeline\Infrastructure\Repositories\EloquentTimelineRepository;

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