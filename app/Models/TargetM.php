<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/4
 * Time: 15:19
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TargetM extends Model
{
    protected $fillable = ['user_id','user_name','u_id','t_id','t_d_id','num','numed'];
}