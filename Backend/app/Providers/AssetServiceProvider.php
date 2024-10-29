<?php

namespace App\Providers;

use App\Services\API\V1\AssetService;
use App\Services\API\V1\IAssetService;
use Illuminate\Support\ServiceProvider;

class AssetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(IAssetService::class, AssetService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
