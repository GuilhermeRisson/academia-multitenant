<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use Database\Seeders\Tenant\PlanSeeder;
use Database\Seeders\Tenant\MemberSeeder;
use Database\Seeders\Tenant\UserTenantSeeder;

class TenantDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PlanSeeder::class,
            MemberSeeder::class,
            UserTenantSeeder::class,
        ]);
    }
}