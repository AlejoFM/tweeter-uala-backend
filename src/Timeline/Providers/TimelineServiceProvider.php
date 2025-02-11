<?php

declare(strict_types=1);

namespace src\Timeline\Providers;

use Illuminate\Support\ServiceProvider;
use src\Timeline\Domain\Repositories\ForYouTimelineRepositoryInterface;
use src\Timeline\Domain\Repositories\FollowingTimelineRepositoryInterface;
use src\Timeline\Infrastructure\Repositories\EloquentForYouTimelineRepository;
use src\Timeline\Infrastructure\Repositories\EloquentFollowingTimelineRepository;
use src\Timeline\Infrastructure\Repositories\CachedForYouTimelineRepository;
use src\Timeline\Infrastructure\Repositories\CachedFollowingTimelineRepository;

class TimelineServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ForYouTimelineRepositoryInterface::class, function ($app) {
            $repository = new EloquentForYouTimelineRepository();
            return new CachedForYouTimelineRepository($repository);
        });

        $this->app->bind(FollowingTimelineRepositoryInterface::class, function ($app) {
            $repository = new EloquentFollowingTimelineRepository();
            return new CachedFollowingTimelineRepository($repository);
        });    }

    public function boot(): void
    {
        $this->loadRoutesFrom(
            __DIR__ . '/../Presentation/Routes/api.php'
        );
    }
} 