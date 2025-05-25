<?php

namespace App\Services\Central;

use App\Models\Central\Domain;
use App\Models\Central\Tenant;
use App\Models\Tenant\User;
use App\Models\Tenant\TenantDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Stancl\Tenancy\Jobs\CreateDatabase;
use Stancl\Tenancy\Jobs\MigrateDatabase;
use Illuminate\Support\Facades\Hash;

class TenantService
{
    public function create(array $data)
    {
        $tenantId = (string) Str::uuid();
        $databaseName = config('tenancy.database.prefix') . $tenantId;

        try {
            // DB::beginTransaction();

            $tenant = Tenant::create([
                'id' => $tenantId,
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

            $tenant->domains()->create([
                'domain' => $data['domain'] . '.' . env('TENANCY_CENTRAL_DOMAIN'),
            ]);

            // DB::commit();
        } catch (\Exception $e) {
            // DB::rollBack();
            
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

            User::create([
                'email' => $data['email'],
                'password' => Hash::make('123456'),
            ]);

            tenancy()->end();

        } catch (\Throwable $th) {
            Log::error('Tenant creation failed after DB creation: ' . $th->getMessage());
            $this->cleanupFailedTenant($tenantId, $databaseName);
            throw $th;
        }

        return $tenant;
    }

    public function update(Tenant $tenant, array $data): Tenant
    {
        $databaseName = config('tenancy.database.prefix') . $tenant->id;

        try {
            DB::beginTransaction();

            $tenant->update([
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

            $domain = $tenant->domains()->first();
            if ($domain) {
                $domain->update([
                    'domain' => $data['domain'] . '.' . env('TENANCY_CENTRAL_DOMAIN'),
                ]);
            }

            DB::commit();

            tenancy()->initialize($tenant);

            $tenantDetail = TenantDetail::first();
            if ($tenantDetail) {
                $tenantDetail->update([
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
            }

            tenancy()->end();

            return $tenant;
        } catch (\Throwable $e) {
            Log::error('Tenant update failed: ' . $e->getMessage());
            throw $e;
        }
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

    public function getTenantStatistics(): array
    {
        $totalTenants = Tenant::count();

        $tenantsThisMonth = Tenant::whereMonth('created_at', now()->month)->count();

        $recentTenants = Tenant::orderBy('created_at', 'desc')->limit(5)->get();

        $tenantsByMonth = Tenant::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('created_at', now()->year)
        ->groupBy('month')
        ->pluck('count', 'month')
        ->toArray();

        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[$i] = $tenantsByMonth[$i] ?? 0;
        }

        return [
            'total_tenants' => $totalTenants,
            'tenants_this_month' => $tenantsThisMonth,
            'recent_tenants' => $recentTenants,
            'monthly_data' => [
                'tenants' => array_values($monthlyData), 
            ],
        ];
    }
}
