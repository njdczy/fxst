<?php


namespace app\Models;


use Illuminate\Database\Eloquent\Model;

class PiaoLog extends Model
{
    public function input()
    {
        return $this->belongsTo(Input::class, 'input_id');
    }

    public function belongs()
    {
        return $this->where('user_id', \Front::user()->user_id);
    }

    public function getNamesByInputId($input_id)
    {
        return $this->where('input_id', $input_id)->pluck('name', 'id');;
    }
}