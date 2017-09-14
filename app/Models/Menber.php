<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/31
 * Time: 13:03
 */

namespace App\Models;

use App\Zhenggg\Traits\AdminBuilder;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;

class Menber extends Model implements AuthenticatableContract
{
    use Authenticatable,AdminBuilder;
    /**
     * A menber belongs to d.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class,'d_id');
    }


    public function menberpers()
    {
        return $this->hasMany(MenberPer::class);
    }
}