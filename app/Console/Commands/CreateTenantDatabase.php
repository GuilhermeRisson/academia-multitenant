<?php
// app/Console/Commands/CreateTenantDatabase.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateTenantDatabase extends Command
{
    protected $signature = 'tenant:create-database {tenant_id}';
    protected $description = 'Cria um banco de dados para um tenant';

    public function handle()
    {
        $tenantId = $this->argument('tenant_id');
        $databaseName = 'academia_' . $tenantId;
        
        try {
            DB::statement("CREATE DATABASE IF NOT EXISTS `{$databaseName}`");
            $this->info("Banco de dados '{$databaseName}' criado com sucesso!");
            
            // Opcional: rodar migrations no novo banco
            $this->call('migrate', [
                '--database' => 'tenant_' . $tenantId,
                '--path' => 'database/migrations/tenant',
            ]);
            
        } catch (\Exception $e) {
            $this->error("Erro ao criar banco de dados: " . $e->getMessage());
        }
    }
}