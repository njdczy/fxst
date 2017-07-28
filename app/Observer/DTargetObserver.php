<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/16
 * Time: 14:45
 */

namespace App\Observer;


use App\Models\DTarget;
use App\Models\Target;
use App\Zhenggg\Facades\Front;

class DTargetObserver
{
    public function saved($d_target)
    {
        //当部门目标saved时，算出总被分配目标数，更新到总目标表
        $num = DTarget::where('user_id',Front::user()->user_id)
            ->where('p_id',$d_target->p_id)
            ->sum('num');
        Target::where('user_id',Front::user()->user_id)
            ->where('p_id',$d_target->p_id)
            ->update(['fnum' => $num]);
    }
}