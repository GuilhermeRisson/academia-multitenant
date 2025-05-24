<?php

declare(strict_types=1);

use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Contracts\Tenant;
use Inertia\Inertia;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\AlunoController;
use App\Http\Controllers\Admin\DashboardController;
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

    Route::get('/', function () {
        return Inertia::render('Gym/LandingPage');
    })->name('home');

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/login', [AuthenticatedSessionController::class, 'create'])
            ->middleware('guest')
            ->name('login');

        Route::post('/login', [AuthenticatedSessionController::class, 'store'])
            ->middleware('guest');

        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->middleware('auth')
            ->name('logout');

        Route::middleware('auth')->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'index'])
                ->name('dashboard');

            Route::resource('alunos', AlunoController::class);
            // Isso gera:
            // GET /admin/alunos -> index
            // GET /admin/alunos/create -> create
            // POST /admin/alunos -> store
            // GET /admin/alunos/{id} -> show
            // GET /admin/alunos/{id}/edit -> edit
            // PUT/PATCH /admin/alunos/{id} -> update
            // DELETE /admin/alunos/{id} -> destroy

        });

    });

});