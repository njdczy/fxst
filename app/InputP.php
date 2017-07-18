<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/16
 * Time: 23:37
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class InputP extends Model
{
    protected $fillable = ['input_id', 'p_id', 'num', 'price', 'created_at', 'updated_at'];

    public function input()
    {
        return $this->belongsTo(Input::class, 'input_id');
    }
}