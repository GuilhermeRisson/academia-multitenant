<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

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

Route::get('/', function ($tenant) {
    return "Bem-vindo ao tenant: " . $tenant;
})->name('tenant.home');

// Adicione aqui todas as rotas específicas dos tenants
Route::get('/dashboard', function ($tenant) {
    return "Dashboard do tenant: " . $tenant;
})->name('tenant.dashboard');
