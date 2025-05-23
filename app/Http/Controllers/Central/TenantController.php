<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Central\Tenant;
use App\Models\Central\Domain;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Inertia\Inertia;

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
                'domain' => $tenant->domains->first()->domain ?? 'N/A'
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
                        $fail('The email has already been taken.');
                    }
                },
            ],
            'domain' => 'required|string|unique:domains,domain',
            'cnpj' => [
                'required',
                'string',
                'regex:/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/',
                function ($attribute, $value, $fail) {
                    if (Tenant::where('data->cnpj', $value)->exists()) {
                        $fail('The CNPJ has already been taken.');
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

        // Create tenant with data in JSON column
        $tenant = Tenant::create([
            'id' => (string) Str::uuid(),
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

        Domain::create([
            'tenant_id' => $tenant->id,
             'domain' => $validated['domain'] . '.' . config('tenancy.central_domains')[2],
        ]);

        return redirect('/dashboard')->with('success', 'Tenant criado com sucesso!');
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->delete();

        return redirect()->route('tenants.index')->with('success', 'Tenant deletado!');
    }
}