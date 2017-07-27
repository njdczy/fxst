<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/26
 * Time: 10:01
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class JituanConfig extends Model
{
    protected $fillable = ['user_id','jituan_name'];
}