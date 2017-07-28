<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/27
 * Time: 17:31
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class SystemUser extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $fillable = ['admin_name', 'password'];
}