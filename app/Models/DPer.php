<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/19
 * Time: 17:11
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class DPer extends Model
{
    public $fillable = ['p_id','d_id'];

    public $timestamps = false;
}