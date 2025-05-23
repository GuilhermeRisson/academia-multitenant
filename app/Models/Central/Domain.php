<?php

namespace App\Models\Central;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    //
    protected $fillable = ['id', 'domain', 'tenant_id'];

     public function domains()
    {
        return $this->hasMany(Domain::class);
    }
}
