<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\StockRepositoryInterface;
use App\Repositories\StockRepository;
use App\Services\StockServiceInterface;
use App\Services\StockService;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(StockRepositoryInterface::class, StockRepository::class);
        $this->app->bind(StockServiceInterface::class, StockService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
