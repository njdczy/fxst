<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/13
 * Time: 14:27
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Periodical extends Model
{
    /**
     * 获取该刊物所属的报社模型。
     */
    public function baoshe()
    {
        return $this->belongsTo(Baoshe::class, 'baoshe_id');
    }
}