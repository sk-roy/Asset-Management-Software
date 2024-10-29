<?php

namespace App\Providers;

use App\Services\API\V1\EventService;
use App\Services\API\V1\IEventService;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(IEventService::class, EventService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
