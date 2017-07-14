<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/14
 * Time: 10:28
 */

namespace App\Observer;


use App\Target;

class PeriodicalObserver
{
    public function deleting($periodical)
    {
        //如果改刊物下面存在目标，则不能删除
        if (Target::where('p_id', $periodical->id)->exists()) {
            return false;
        }
    }
}