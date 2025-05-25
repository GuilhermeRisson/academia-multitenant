<?php

declare(strict_types=1);

use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Tenant\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Tenant\Admin\MemberController;
use App\Http\Controllers\Tenant\Admin\DashboardController;
/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    // Páginas de erro específicas do tenant
    Route::view('/empresa-nao-encontrada', 'errors.tenant-not-found')->name('tenant.notfound');
    Route::view('/empresa-desativada', 'errors.tenant-inactive')->name('tenant.inactive');

    // Landing page
    Route::get('/', fn() => Inertia::render('Gym/LandingPage'))->name('home');

    // Rotas administrativas
    Route::prefix('admin')->name('admin.')->group(function () {

        // Autenticação
        Route::middleware('guest:tenant')->group(function () {
            Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
            Route::post('/login', [AuthenticatedSessionController::class, 'store']);
        });

        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->middleware('auth:tenant')
            ->name('logout');

        // Rotas protegidas
        Route::middleware('auth:tenant')->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::resource('members', MemberController::class);
            Route::get('/tenants', [DashboardController::class, 'show'])->name('tenants.show');
            Route::post('/tenants/logo', [DashboardController::class, 'updateLogo'])->name('tenants.logo.update');
        });
    });
});