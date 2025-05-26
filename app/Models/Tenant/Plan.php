<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = ['name', 'price', 'features'];
}
