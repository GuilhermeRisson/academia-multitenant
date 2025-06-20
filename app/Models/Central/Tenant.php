<?php

namespace App\Models\Central;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;


class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDomains, HasDatabase;

    protected $fillable = [
        'id',
        'name',
        'email',
        'cnpj',
        'street',
        'number',
        'complement',
        'city',
        'state',
        'postal_code',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'email',
            'cnpj',
            'street',
            'number',
            'complement',
            'city',
            'state',
            'postal_code',
            'data',
        ];
    }
}