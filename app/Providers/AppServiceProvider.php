<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Use Tailwind-compatible pagination views
        Paginator::useTailwind();

        // Prevent lazy loading in local/testing to catch N+1 queries early
        // Model::preventLazyLoading(! app()->isProduction());
    }
}
