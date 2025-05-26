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
        return inertia('Admin/Plans/Index', compact('plans'));
    }

    public function show($id)
    {
        $plan = $this->planService->find($id);
        if (!$plan) {
            abort(404);
        }
        return inertia('Admin/Plans/Show', compact('plan'));
    }

    public function create()
    {
        return inertia('Admin/Plans/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'features' => 'nullable|string',
        ]);

        $this->planService->create($data);

        return redirect()->route('admin.plans.index')->with('success', 'Plano criado com sucesso!');
    }

    public function edit($id)
    {
        $plan = $this->planService->find($id);
        if (!$plan) {
            abort(404);
        }
        return inertia('Admin/Plans/Edit', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'features' => 'nullable|string',
        ]);

        $updated = $this->planService->update($id, $data);

        if (!$updated) {
            abort(404);
        }

        return redirect()->route('admin.plans.index')->with('success', 'Plano atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $deleted = $this->planService->delete($id);

        if (!$deleted) {
            abort(404);
        }

        return redirect()->route('admin.plans.index')->with('success', 'Plano deletado com sucesso!');
    }
}