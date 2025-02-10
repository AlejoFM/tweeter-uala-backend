<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\InMemory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CollectorRegistry::class, function () {
            return new CollectorRegistry(new InMemory());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $registry = app(CollectorRegistry::class);
        
        // Contador de requests
        $counter = $registry->getOrRegisterCounter('app', 'http_requests_total', 'Total requests');
        
        // Incrementar en cada request
        app('router')->matched(function () use ($counter) {
            $counter->inc();
        });
    }
}
