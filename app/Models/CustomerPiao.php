<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/7
 * Time: 18:27
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CustomerPiao extends Model
{
    protected $fillable = ['user_id','name','hao','addr','phone','bank','bank_account'];

    public function customer()
    {
        return  $this->belongsTo(Customer::class,'c_id');
    }
}