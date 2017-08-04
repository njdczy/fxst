<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/13
 * Time: 17:56
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    public function periodical()
    {
        return $this->belongsTo(Periodical::class,'p_id');
    }

    public function targetds()
    {
        return $this->hasMany(TargetD::class,'target_id');
    }
}