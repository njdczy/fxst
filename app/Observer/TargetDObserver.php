<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/4
 * Time: 14:04
 */

namespace App\Observer;


use App\Models\TargetD;

class TargetDObserver
{

    public function deleted($target_d)
    {
        TargetD::where('parent_d_id',$target_d->d_id)->delete();
    }
}