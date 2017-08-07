<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function customer_piaos()
    {
        return $this->hasMany(CustomerPiao::class,'c_id');
    }
}
