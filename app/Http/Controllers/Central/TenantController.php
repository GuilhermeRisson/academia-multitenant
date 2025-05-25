<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Central\Tenant;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use App\Services\Central\TenantService;

class TenantController extends Controller
{
    protected $tenantService;

    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
    }

    public function index(Request $request)
    {
        $query = Tenant::query()->with('domains');

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
        }

        $stats = $this->tenantService->getTenantStatistics();

        $tenants = $query->get()->map(function ($tenant) {
            return [
                'id' => $tenant->id,
                'name' => $tenant->name,
                'email' => $tenant->email,
                'domain' => $tenant->domains->first()->domain ?? null,
                'created_at' => $tenant->created_at->format('d/m/Y H:i'),
            ];
        });

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'companies' => $tenants,
            'filters' => $request->only(['search']),
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

        try {
            $this->tenantService->create($validated);

            return redirect()
                ->route('dashboard')
                ->with('success', 'Academia cadastrada com sucesso!');

        } catch (\Exception $e) {
            Log::error('Tenant creation failed at central DB: ' . $e->getMessage());
            return back()
                ->with('error', 'Erro ao cadastrar: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Tenant $tenant)
    {

        $domain = $tenant->domains()->first();

        return Inertia::render('Tenants/Edit', [
            'tenant' => [
                'id' => $tenant->id,
                'name' => $tenant->name,
                'email' => $tenant->email,
                'cnpj' => $tenant->cnpj,
                'street' => $tenant->street,
                'number' => $tenant->number,
                'complement' => $tenant->complement,
                'city' => $tenant->city,
                'state' => $tenant->state,
                'postal_code' => $tenant->postal_code,
                'domain' => $domain ? str_replace('.' . env('TENANCY_CENTRAL_DOMAIN'), '', $domain->domain) : '',
            ],
        ]);
    }

    public function update(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) use ($tenant) {
                    if (Tenant::where('data->email', $value)->where('id', '!=', $tenant->id)->exists()) {
                        $fail('Este email já está em uso.');
                    }
                },
            ],
            'domain' => [
                'required',
                'string',
                'regex:/^[a-z0-9-]+$/',
                function ($attribute, $value, $fail) use ($tenant) {
                    $fullDomain = $value . '.' . env('TENANCY_CENTRAL_DOMAIN');
                    if (\App\Models\Central\Domain::where('domain', $fullDomain)->where('tenant_id', '!=', $tenant->id)->exists()) {
                        $fail('Este domínio já está em uso.');
                    }
                },
            ],
            'cnpj' => [
                'required',
                'string',
                'regex:/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/',
                function ($attribute, $value, $fail) use ($tenant) {
                    if (Tenant::where('data->cnpj', $value)->where('id', '!=', $tenant->id)->exists()) {
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

        try {
            $this->tenantService->update($tenant, $validated);

            return redirect()
                ->route('dashboard')
                ->with('success', 'Academia atualizada com sucesso!');

        } catch (\Exception $e) {
            Log::error('Tenant update failed: ' . $e->getMessage());
            return back()
                ->with('error', 'Erro ao atualizar: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Tenant $tenant)
    {
        try {
            $this->tenantService->delete($tenant);

            return redirect()
                ->route('dashboard')
                ->with('success', 'Academia removida com sucesso!');

        } catch (\Exception $e) {
            Log::error('Tenant deletion failed: ' . $e->getMessage());
            return back()
                ->with('error', 'Erro ao remover academia: ' . $e->getMessage());
        }
    }
}
