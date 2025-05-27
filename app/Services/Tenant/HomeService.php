<?php

namespace App\Services\Tenant;

use App\Models\Tenant\TenantDetail;
use App\Models\Tenant\Plan;

class HomeService
{
    public function getTenantInfo(): array
    {
        $tenant = TenantDetail::first();
        
        $plans = Plan::get();

        return [
            'logo_url' => $tenant->logo_url ?? null,
            'company_name' => $tenant->name ?? 'Minha Empresa',
            'plans' => $plans,
        ];
    }
}
