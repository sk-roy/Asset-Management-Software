<?php

namespace App\Providers;

use App\Services\API\V1\DocumentService;
use App\Services\API\V1\IDocumentService;
use Illuminate\Support\ServiceProvider;

class DocumentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(IDocumentService::class, DocumentService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
