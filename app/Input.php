<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/16
 * Time: 23:30
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Input extends Model
{
    public $fillable = ['d_id'];

    public function input_ps()
    {
        return $this->hasMany(InputP::class, 'input_id');
    }
}