<?php

namespace App\Providers;

use App\Repositories\EloquentFabricRepository;
use App\Repositories\EloquentOwnerRepository;
use App\Repositories\OwnerRepositoryInterface;
use App\Repositories\FabricRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(OwnerRepositoryInterface::class, EloquentOwnerRepository::class);

        $this->app->bind(FabricRepositoryInterface::class, EloquentFabricRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
