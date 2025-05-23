<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            // Rotas da aplicação central (não tenant)
            $this->mapCentralRoutes();
            
            // Rotas para tenants (subdomínios)
            $this->mapTenantRoutes();
            
            // Rotas API (se necessário)
            $this->mapApiRoutes();
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    /**
     * Define as rotas centrais (não tenant)
     */
    protected function mapCentralRoutes()
    {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define as rotas para tenants (subdomínios)
     */
    protected function mapTenantRoutes()
    {
        Route::middleware([
            'web',
            'tenancy' // Seu middleware de tenancy
        ])
        ->domain('{tenant}.academia-multitenant.test')
        ->group(base_path('routes/tenant.php'));
    }

    /**
     * Define as rotas da API
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('routes/api.php'));
    }
}