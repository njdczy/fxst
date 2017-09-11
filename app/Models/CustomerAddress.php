<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/11
 * Time: 18:23
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{

    protected $fillable = ['user_id','province','city','district','address','youbian'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return  $this->belongsTo(Customer::class,'c_id');
    }
}