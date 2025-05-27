<?php

namespace Database\Seeders;

use App\Services\Central\TenantService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        $tenantService = app(TenantService::class);

        $tenants = [
            [
                'name' => 'academia1',
                'email' => 'academia1@gmail.com',
                'cnpj' => '12345678000101',
                'street' => 'Rua A',
                'number' => '100',
                'complement' => '',
                'city' => 'São Paulo',
                'state' => 'SP',
                'postal_code' => '01000-000',
                'domain' => 'academia1',
            ],
            [
                'name' => 'academia2',
                'email' => 'academia2@gmail.com',
                'cnpj' => '98765432000109',
                'street' => 'Rua B',
                'number' => '200',
                'complement' => '',
                'city' => 'Rio de Janeiro',
                'state' => 'RJ',
                'postal_code' => '20000-000',
                'domain' => 'academia2',
            ],
        ];

        foreach ($tenants as $tenantData) {
            $tenant = $tenantService->create($tenantData);

            tenancy()->initialize($tenant);

            $this->call(\Database\Seeders\Tenant\TenantDatabaseSeeder::class);

            tenancy()->end();
        }
    }
}
