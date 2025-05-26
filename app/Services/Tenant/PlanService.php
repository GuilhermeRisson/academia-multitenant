<?php

namespace App\Services\Tenant;

use App\Models\Tenant\Plan;

class PlanService
{
    public function all()
    {
        return Plan::all();
    }

    public function find(int $id)
    {
        return Plan::find($id);
    }

    public function create(array $data)
    {
        return Plan::create($data);
    }

    public function update(int $id, array $data)
    {
        $plan = $this->find($id);

        if (!$plan) {
            return false;
        }

        $plan->update($data);

        return true;
    }

    public function delete(int $id)
    {
        $plan = $this->find($id);

        if (!$plan) {
            return false;
        }

        $plan->delete();

        return true;
    }
}