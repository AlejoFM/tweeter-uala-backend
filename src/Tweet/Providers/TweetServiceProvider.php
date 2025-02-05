<?php
declare(strict_types=1);

namespace App\Tweet\Providers;

use Illuminate\Support\ServiceProvider;
use App\Tweet\Domain\Repositories\TweetRepositoryInterface;
use App\Tweet\Infrastructure\Repositories\EloquentTweetRepository;

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