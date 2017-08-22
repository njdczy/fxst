<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PiaoLog extends Model
{
    public function input()
    {
        return $this->belongsTo(Input::class, 'input_id');
    }
}