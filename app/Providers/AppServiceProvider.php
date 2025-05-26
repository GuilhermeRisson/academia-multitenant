<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Stancl\Tenancy\Tenancy;

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
        Vite::prefetch(concurrency: 3);

        if (app()->bound(Tenancy::class) && tenancy()->initialized) {
            Config::set('session.cookie', 'tenant_session_' . tenancy()->tenant->id);
        } else {
            Config::set('session.cookie', 'central_session');
        }
    }
}
