<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'birth_date',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'postal_code',
        'active',
        'registration_date'
    ];
      
}
