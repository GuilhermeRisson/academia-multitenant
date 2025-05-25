<?php

namespace App\Services\Tenant;

use App\Models\Tenant\Member;

class DashboardService
{
    public function getData(): array
    {
        return [
            'total_members' => Member::count(),
            'members_this_month' => Member::whereMonth('created_at', now()->month)->count(),
            'recent_members' => Member::orderBy('created_at', 'desc')->limit(5)->get(),
        ];
    }
}
