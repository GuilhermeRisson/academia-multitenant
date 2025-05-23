<?php

namespace App\Models\Central;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = ['id', 'data'];

    protected $casts = [
        'data' => 'array', // Automatically cast JSON to array
    ];

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }
}
