<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/27
 * Time: 9:39
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Baoshe extends Model
{
    /**
     * 获取这个报社下的所有刊物。
     */
    public function periodical()
    {
        return $this->hasMany(Periodical::class, 'baoshe_id');
    }
}