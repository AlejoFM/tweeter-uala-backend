<?php
declare(strict_types=1);

namespace src\Tweet\Providers;

use Illuminate\Support\ServiceProvider;
use src\Tweet\Domain\Repositories\TweetRepositoryInterface;
use src\Tweet\Domain\Repositories\CreateTweetRepositoryInterface;
use src\Tweet\Domain\Repositories\EloquentFindByIdTweetRepositoryInterface;
use src\Tweet\Infrastructure\Repositories\EloquentTweetRepository;
use src\Tweet\Infrastructure\Repositories\EloquentCreateTweetRepository;
use src\Tweet\Infrastructure\Repositories\EloquentFindByIdTweetRepository;

class TweetServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CreateTweetRepositoryInterface::class, EloquentCreateTweetRepository::class);
        $this->app->bind(EloquentFindByIdTweetRepositoryInterface::class, EloquentFindByIdTweetRepository::class);
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(
            __DIR__ . '/../Presentation/Routes/api.php'
        );
    }
} 