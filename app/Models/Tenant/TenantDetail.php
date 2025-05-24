<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class TenantDetail extends Model
{
    protected $table = 'tenant_details';

    protected $fillable = [
        'name',
        'email',
        'cnpj',
        'street',
        'number',
        'complement',
        'city',
        'state',
        'postal_code',
    ];
}
