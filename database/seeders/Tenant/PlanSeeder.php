<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use App\Models\Tenant\Plan;

class PlanSeeder extends Seeder
{
    public function run()
    {
        Plan::create([
            'name' => 'Plano Básico',
            'price' => 29.90,
            'features' => 'Acesso à academia, aulas básicas',
        ]);

        Plan::create([
            'name' => 'Plano Premium',
            'price' => 59.90,
            'features' => 'Acesso total + personal trainer',
        ]);

        Plan::create([
            'name' => 'Plano Familiar',
            'price' => 89.90,
            'features' => 'Acesso total + personal trainer',
        ]);
    }
}
