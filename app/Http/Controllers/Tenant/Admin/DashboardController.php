<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\TenantDetail;
use App\Services\Tenant\DashboardService;

class DashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $data = $this->dashboardService->getData();
        return inertia('Gym/Admin/Dashboard', $data);
    }

    public function show()
    {
        $data = $this->dashboardService->show();
        return inertia('Gym/Admin/Profile/Profile', $data);
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpg,jpeg,png,svg|max:2048'
        ]);

        $tenant = TenantDetail::first(); // Aqui pode ser ajustado para pegar o tenant correto

        $logoUrl = $this->dashboardService->saveLogo($tenant, $request->file('logo'));

        return back()->with('success', 'Logo atualizada com sucesso!')->with('logo_url', $logoUrl);
    }
}
