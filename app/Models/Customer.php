<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function customer_piao()
    {
        return $this->hasOne(CustomerPiao::class,'c_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customer_addresses()
    {
        return $this->hasMany(CustomerAddress::class,'c_id');
    }
}
