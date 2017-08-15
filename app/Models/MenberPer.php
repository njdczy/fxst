<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class MenberPer extends Model
{
    protected $fillable = ['user_id','menber_id','p_id','type','per'];
}