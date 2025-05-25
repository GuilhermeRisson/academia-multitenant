<?php

namespace App\Services\Tenant;

use App\Models\Tenant\Member;

class MemberService
{
    public function list()
    {
        return Member::orderBy('name')->paginate(15);
    }

    public function findById(int $id): Member
    {
        return Member::findOrFail($id);
    }

    public function create(array $data): Member
    {
        return Member::create($data);
    }

    public function update(int $id, array $data): Member
    {
        $member = $this->findById($id);
        $member->update($data);
        return $member;
    }

    public function delete(int $id): void
    {
        $member = $this->findById($id);
        $member->delete();
    }
}
