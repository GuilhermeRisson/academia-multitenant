<?php
// app/Database/DatabaseManager.php

namespace App\Database;

use Illuminate\Database\DatabaseManager as BaseDatabaseManager;
use Illuminate\Database\Connection;

class DatabaseManager extends BaseDatabaseManager
{
    public function connection($name = null)
    {
        if (!tenancy()->initialized) {
            return parent::connection($name);
        }

        $tenant = tenant();

        $connectionName = 'tenant_' . $tenant->id;

        if (!isset($this->app['config']['database.connections.' . $connectionName])) {
            $this->makeTenantConnection($tenant, $connectionName);
        }

        return parent::connection($connectionName);
    }

    protected function makeTenantConnection($tenant, $connectionName)
    {
        $config = config('database.connections.mysql');
        
        $config['database'] = 'academia_' . $tenant->id; 
    
        config(['database.connections.' . $connectionName => $config]);
    }
}