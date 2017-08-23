<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/20
 * Time: 17:13
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UCheckout extends Model
{
    public function menber()
    {
        $this->belongsTo(Menber::class,'u_id');
    }

    public function department()
    {
        $this->belongsTo(Department::class,'d_id');
    }
}