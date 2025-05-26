<?php

namespace App\Services\Tenant;

use App\Models\Tenant\TenantDetail;

class HomeService
{
    public function getTenantInfo(): array
    {
        $tenant = TenantDetail::first();
        
        return [
            'logo_url' => $tenant->logo_url ?? null,
            'company_name' => $tenant->name ?? 'Minha Empresa',
        ];
    }
}
