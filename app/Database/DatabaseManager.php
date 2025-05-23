<?php
// app/Database/DatabaseManager.php

namespace App\Database;

use Illuminate\Database\DatabaseManager as BaseDatabaseManager;
use Illuminate\Database\Connection;

class DatabaseManager extends BaseDatabaseManager
{
    public function connection($name = null)
    {
        // Se não houver tenant definido, usa a conexão padrão
        if (!tenancy()->initialized) {
            return parent::connection($name);
        }

        // Obtém o tenant atual
        $tenant = tenant();

        // Nome da conexão do tenant (usando o ID ou domínio)
        $connectionName = 'tenant_' . $tenant->id;

        // Configura a conexão se não existir
        if (!isset($this->app['config']['database.connections.' . $connectionName])) {
            $this->makeTenantConnection($tenant, $connectionName);
        }

        return parent::connection($connectionName);
    }

    protected function makeTenantConnection($tenant, $connectionName)
    {
        // Configuração baseada no seu banco de dados principal
        $config = config('database.connections.mysql');
        
        // Modifica o nome do banco de dados para o do tenant
        $config['database'] = 'academia_' . $tenant->id; // ou outro padrão que preferir
        
        // Adiciona a nova conexão à configuração
        config(['database.connections.' . $connectionName => $config]);
    }
}