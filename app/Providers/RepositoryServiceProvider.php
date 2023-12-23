<?php

namespace App\Providers;

use App\Repositories\EloquentOwnerRepository;
use App\Repositories\OwnerRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(OwnerRepositoryInterface::class, EloquentOwnerRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
