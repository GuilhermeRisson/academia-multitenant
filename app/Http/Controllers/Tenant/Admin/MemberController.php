<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Tenant\MemberService;

class MemberController extends Controller
{
    protected MemberService $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    public function index()
    {
        $members = $this->memberService->list();
        return inertia('Gym/Admin/Members/Index', compact('members'));
    }

    public function create()
    {
        return inertia('Gym/Admin/Members/Create');
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
        ]);

        $this->memberService->create($data);

        return redirect()->route('admin.members.index')->with('success', 'Member created successfully!');
    }

    public function show($id)
    {
        $member = $this->memberService->findById($id);
        return inertia('Gym/Admin/Members/Show', compact('member'));
    }

    public function edit($id)
    {
        $member = $this->memberService->findById($id);
        return inertia('Gym/Admin/Members/Edit', compact('member'));
    }

    public function update(Request $request, $id)
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
        ]);

        $this->memberService->update($id, $data);

        return redirect()->route('admin.members.index')->with('success', 'Member updated successfully!');
    }

    public function destroy($id)
    {
        $this->memberService->delete($id);
        return redirect()->route('admin.members.index')->with('success', 'Member deleted successfully!');
    }
}
