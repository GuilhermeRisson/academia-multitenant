<?php

namespace App\Services\Central;

use App\Models\Central\Domain;
use App\Models\Central\Tenant;
use App\Models\Tenant\TenantDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Stancl\Tenancy\Jobs\CreateDatabase;
use Stancl\Tenancy\Jobs\MigrateDatabase;

class TenantService
{
    public function create(array $data)
    {
        $tenantId = (string) Str::uuid();
        $databaseName = config('tenancy.database.prefix') . $tenantId;


        try {
            $tenant = Tenant::create([
                'id' => $tenantId,
                'name' => $data['name'],
                'email' => $data['email'],
                'cnpj' => $data['cnpj'],
                'street' => $data['street'],
                'number' => $data['number'],
                'complement' => $data['complement'],
                'city' => $data['city'],
                'state' => $data['state'],
                'postal_code' => $data['postal_code'],
            ]);

            $tenant->domains()->create([
                'domain' => $data['domain'] . '.' . env('TENANCY_CENTRAL_DOMAIN'),
            ]);


        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Tenant creation failed at central DB: ' . $e->getMessage());
            throw $e;
        }

        try {
            $this->createTenantDatabase($tenant, $databaseName);

            tenancy()->initialize($tenant);

            TenantDetail::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'cnpj' => $data['cnpj'],
                'street' => $data['street'],
                'number' => $data['number'],
                'complement' => $data['complement'] ?? null,
                'city' => $data['city'],
                'state' => $data['state'],
                'postal_code' => $data['postal_code'],
            ]);

            tenancy()->end();

        } catch (\Throwable $th) {
            Log::error('Tenant creation failed after DB creation: ' . $e->getMessage());
            $this->cleanupFailedTenant($tenantId, $databaseName);
            throw $e;
        }

        return $tenant;

    }

     protected function createTenantDatabase($tenant, $databaseName)
    {
        $exists = DB::connection('mysql')->select(
            "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", 
            [$databaseName]
        );

        if (empty($exists)) {
            CreateDatabase::dispatchSync($tenant);
        }

        MigrateDatabase::dispatchSync($tenant);
    }

    public function delete(Tenant $tenant)
    {
        $databaseName = config('tenancy.database.prefix') . $tenant->id;

        try {
            $tenant->domains()->delete();
            $tenant->delete();

            DB::statement("DROP DATABASE IF EXISTS `$databaseName`");

        } catch (\Exception $e) {
            Log::error('Tenant deletion failed: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function cleanupFailedTenant($tenantId, $databaseName)
    {
        Domain::where('tenant_id', $tenantId)->delete();
        Tenant::where('id', $tenantId)->delete();

        try {
            DB::statement("DROP DATABASE IF EXISTS `$databaseName`");
        } catch (\Exception $e) {
            Log::error("Failed to drop database during cleanup: " . $e->getMessage());
        }
    }
}
