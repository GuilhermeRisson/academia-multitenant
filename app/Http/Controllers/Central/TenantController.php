<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Central\Tenant;
use App\Models\Central\Domain;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Stancl\Tenancy\Jobs\CreateDatabase;
use Stancl\Tenancy\Jobs\MigrateDatabase;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        $query = Tenant::query()->with('domains');
        
        if ($request->search) {
            $query->where('data->name', 'like', "%{$request->search}%")
                ->orWhere('data->email', 'like', "%{$request->search}%");
        }

        $tenants = $query->get()->map(function ($tenant) {
            return [
                'id' => $tenant->id,
                'name' => $tenant->data['name'] ?? 'N/A',
                'email' => $tenant->data['email'] ?? 'N/A',
                'domain' => $tenant->domains->first()->domain ?? 'N/A',
                'created_at' => $tenant->created_at->format('d/m/Y H:i')
            ];
        });

        return Inertia::render('Dashboard', [
            'stats' => ['totalTenants' => $tenants->count()],
            'companies' => $tenants,
            'filters' => $request->only(['search'])
        ]);
    }

    public function create()
    {
        return Inertia::render('Tenants/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    if (Tenant::where('data->email', $value)->exists()) {
                        $fail('Este email já está em uso.');
                    }
                },
            ],
            'domain' => 'required|string|regex:/^[a-z0-9-]+$/|unique:domains,domain',
            'cnpj' => [
                'required',
                'string',
                'regex:/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/',
                function ($attribute, $value, $fail) {
                    if (Tenant::where('data->cnpj', $value)->exists()) {
                        $fail('Este CNPJ já está cadastrado.');
                    }
                },
            ],
            'street' => 'required|string|max:255',
            'number' => 'required|string|max:50',
            'complement' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|size:2',
            'postal_code' => 'required|string|regex:/^\d{5}-\d{3}$/',
        ]);

        $tenantId = (string) Str::uuid();
        $databaseName = config('tenancy.database.prefix') . $tenantId;

        try {
            // 1. Create tenant record
            $tenant = Tenant::create([
                'id' => $tenantId,
                'data' => [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'cnpj' => $validated['cnpj'],
                    'street' => $validated['street'],
                    'number' => $validated['number'],
                    'complement' => $validated['complement'],
                    'city' => $validated['city'],
                    'state' => $validated['state'],
                    'postal_code' => $validated['postal_code'],
                ],
            ]);

            // 2. Create domain record
            $tenant->domains()->create([
                'domain' => $validated['domain'],
            ]);

            // 3. Handle tenant database operations
            $this->createTenantDatabase($tenant, $databaseName);

            return redirect()
                ->route('dashboard')
                ->with('success', 'Academia cadastrada com sucesso!');

        } catch (\Exception $e) {
            Log::error('Tenant creation failed: ' . $e->getMessage(), [
                'exception' => $e,
                'tenant_id' => $tenantId ?? null,
                'request' => $request->all()
            ]);

            $this->cleanupFailedTenant($tenantId, $databaseName);

            return back()
                ->with('error', 'Erro ao cadastrar: ' . $e->getMessage())
                ->withInput();
        }
    }

    protected function createTenantDatabase($tenant, $databaseName)
    {
        try {
            // Check if database already exists
            $exists = DB::connection('mysql')->select(
                "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", 
                [$databaseName]
            );

            if (empty($exists)) {
                CreateDatabase::dispatchSync($tenant);
            }
            
            MigrateDatabase::dispatchSync($tenant);

        } catch (\Exception $e) {
            Log::error('Tenant database creation failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function destroy(Tenant $tenant)
    {
        $databaseName = config('tenancy.database.prefix') . $tenant->id;

        try {
            // Delete related records
            $tenant->domains()->delete();
            $tenant->delete();

            // Drop tenant database
            try {
                DB::statement("DROP DATABASE IF EXISTS `$databaseName`");
            } catch (\Exception $e) {
                Log::error("Failed to drop tenant database: " . $e->getMessage());
            }

            return redirect()
                ->route('dashboard')
                ->with('success', 'Academia removida com sucesso!');

        } catch (\Exception $e) {
            Log::error('Tenant deletion failed: ' . $e->getMessage(), [
                'tenant_id' => $tenant->id,
            ]);

            return back()
                ->with('error', 'Erro ao remover academia: ' . $e->getMessage());
        }
    }

    protected function cleanupFailedTenant($tenantId, $databaseName)
    {
        try {
            // Delete domain if exists
            Domain::where('tenant_id', $tenantId)->delete();
            
            // Delete tenant if exists
            Tenant::where('id', $tenantId)->delete();
            
            // Try to drop database if exists
            try {
                DB::statement("DROP DATABASE IF EXISTS `$databaseName`");
            } catch (\Exception $e) {
                Log::error("Failed to drop database during cleanup: " . $e->getMessage());
            }
        } catch (\Exception $e) {
            Log::error("Cleanup failed for tenant {$tenantId}: " . $e->getMessage());
        }
    }
}