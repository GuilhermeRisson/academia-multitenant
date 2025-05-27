<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Tenant\PlanService;

class PlanController extends Controller
{
    protected PlanService $planService;

    public function __construct(PlanService $planService)
    {
        $this->planService = $planService;
    }

    public function index()
    {
        $plans = $this->planService->all();
        return inertia('Gym/Admin/Plans/Index', compact('plans'));
    }

    public function create()
    {
        return inertia('Gym/Admin/Plans/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'features' => 'nullable|array',
            'features.*' => 'string',
        ]);

        $this->planService->create($data);

        return redirect()->route('admin.plans.index')->with('success', 'Plano criado com sucesso!');
    }

    public function edit(Request $request)
    {
        $id = $request->route('plan');
        $plan = $this->planService->find($id);
        if (!$plan) {
            abort(404);
        }
        return inertia('Gym/Admin/Plans/Edit', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        $id = $request->route('plan');
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'features' => 'nullable|array',
            'features.*' => 'string',
        ]);

        $updated = $this->planService->update($id, $data);

        if (!$updated) {
            abort(404);
        }

        return redirect()->route('admin.plans.index')->with('success', 'Plano atualizado com sucesso!');
    }

    public function destroy(Request $request)
    {
        $id = $request->route('plan');
        $deleted = $this->planService->delete($id);

        if (!$deleted) {
            abort(404);
        }

        return redirect()->route('admin.plans.index')->with('success', 'Plano deletado com sucesso!');
    }
}