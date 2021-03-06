<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/16
 * Time: 23:30
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Input extends Model
{
    public $fillable = ['d_id','dis_status','pay_name','input_status'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'd_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'c_id');
    }

    public function fapiaos()
    {
        return $this->hasMany(PiaoLog::class, 'input_id');
    }

    public function liushuis()
    {
        return $this->hasMany(LiushuiLog::class, 'input_id');
    }
}