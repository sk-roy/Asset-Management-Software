<?php

namespace App\Providers;

use App\Services\API\V1\NoteService;
use App\Services\API\V1\INoteService;
use Illuminate\Support\ServiceProvider;

class NoteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(INoteService::class, NoteService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
