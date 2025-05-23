<?php
// app/Observers/TenantObserver.php

namespace App\Observers;

use App\Models\Tenant;
use Illuminate\Support\Facades\Artisan;

class TenantObserver
{
    public function created(Tenant $tenant)
    {
        // Cria o banco de dados
        Artisan::call('tenant:create-database', ['tenant_id' => $tenant->id]);
        
        // Opcional: seed inicial
        Artisan::call('db:seed', [
            '--database' => 'tenant_' . $tenant->id,
            '--class' => 'TenantDatabaseSeeder'
        ]);
    }
}