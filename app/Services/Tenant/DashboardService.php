<?php

namespace App\Services\Tenant;

use App\Models\Tenant\Member;
use Illuminate\Support\Facades\DB;
class DashboardService
{
    public function getData(): array
    {
        return [
            'total_members' => Member::count(),
            'members_this_month' => Member::whereMonth('created_at', now()->month)->count(),
            'recent_members' => Member::orderBy('created_at', 'desc')->limit(5)->get(),
            'monthly_data' => $this->getMonthlyMemberData(),
        ];
    }

     private function getMonthlyMemberData(): array
    {
        $membersByMonth = Member::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = $membersByMonth[$i] ?? 0;
        }

        return [
            'members' => $data,
        ];
    }
}
