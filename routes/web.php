<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Central\AuthController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Central\TenantController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Inertia\Inertia;

// 🔵 Rotas do sistema central
Route::middleware(['web'])->domain('academia-multitenant.test')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/', function () {
            return Inertia::render('Tenants/LandingPage');
        })->name('home');
    
        Route::get('/login', [AuthController::class, 'index'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
    });

    Route::middleware('web','auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/dashboard', [TenantController::class, 'index'])->name('dashboard');

        Route::prefix('profile')->group(function () {
            Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        });

        Route::prefix('tenants')->group(function () {
            Route::get('/create', [TenantController::class, 'create'])->name('tenants.create');
            Route::post('/', [TenantController::class, 'store'])->name('tenants.store');
                
        });
    });
});

// 🟢 Rotas dos tenants
Route::middleware([
        'web',
        InitializeTenancyByDomain::class,
        PreventAccessFromCentralDomains::class,
    ])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index']);
    });
