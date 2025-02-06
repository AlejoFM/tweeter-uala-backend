<?php
declare(strict_types=1);

namespace src\Tweet\Providers;

use Illuminate\Support\ServiceProvider;
use src\Tweet\Domain\Repositories\TweetRepositoryInterface;
use src\Tweet\Infrastructure\Repositories\EloquentTweetRepository;

class TweetServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TweetRepositoryInterface::class, EloquentTweetRepository::class);
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(
            __DIR__ . '/../Infrastructure/Routes/api.php'
        );
    }
} 