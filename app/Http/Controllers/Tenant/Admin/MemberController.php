<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Tenant\MemberService;
use App\Services\Tenant\PlanService;
use App\Models\Tenant\Member;

class MemberController extends Controller
{
    protected MemberService $memberService;
    protected PlanService $planService; 

    public function __construct(MemberService $memberService, PlanService $planService) 
    {
        $this->memberService = $memberService;
        $this->planService = $planService;
    }

    public function index()
    {
        $members = $this->memberService->list();
        return inertia('Gym/Admin/Members/Index', compact('members'));
    }

    public function create()
    {
        $plans = $this->planService->all(); 
        return inertia('Gym/Admin/Members/Create', compact('plans')); 
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:members,email',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'street' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:10',
            'complement' => 'nullable|string|max:100',
            'neighborhood' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:2',
            'postal_code' => 'nullable|string|max:9',
            'active' => 'boolean',
            'registration_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'plan_id' => 'nullable|exists:plans,id',
        ]);

        $this->memberService->create($data);

        return redirect()->route('admin.members.index')->with('success', 'Member created successfully!');
    }

    public function show(Request $request)
    {
        $id = $request->route('member');
        $member = Member::with('plan')->findOrFail($id);
        return inertia('Gym/Admin/Members/Show', compact('member'));
    }

    public function edit(Request $request)
    {
        $id = $request->route('member');
        $member = $this->memberService->findById($id);
        $plans = $this->planService->all();
        return inertia('Gym/Admin/Members/Edit', compact('member', 'plans'));
    }

    public function update(Request $request, $id)
    {
        $id = $request->route('member');

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:members,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'street' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:10',
            'complement' => 'nullable|string|max:100',
            'neighborhood' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:2', 
            'postal_code' => 'nullable|string|max:9',
            'active' => 'boolean',
            'registration_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'plan_id' => 'nullable|exists:plans,id',
        ]);

        $this->memberService->update($id, $data);

        return redirect()->route('admin.members.index')->with('success', 'Member updated successfully!');
    }

    public function destroy(Request $request)
    {
        $id = $request->route('member');

        $this->memberService->delete($id);
        return redirect()->route('admin.members.index')->with('success', 'Member deleted successfully!');
    }
}
