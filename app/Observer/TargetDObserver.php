<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/4
 * Time: 14:04
 */

namespace App\Observer;


use App\Models\Input;
use App\Models\TargetD;

class TargetDObserver
{
    public function created($target_d)
    {
        //目标相关的所有订单
        $inputs = Input::where('user_id', '=', \Front::user()->user_id)
            ->where('p_id', $target_d->p_id)
            ->where('d_id', $target_d->d_id)
            ->whereBetween('created_at',[$target_d->s_time,$target_d->e_time])
            ->get();
        if ($inputs) {
            $target_d_numed = 0;
            $target_d_moneyed = 0.00;
            foreach ($inputs as $key => $input) {
                if ($input->input_status == 1 &&  $input->input_type == 'y') {
                    $target_d_numed = $target_d_numed + $input->num ;
                }
                if ($input->input_status == 1) {
                    $target_d_moneyed = $target_d_moneyed + $input->p_amount ;
                }
            }
            $target_d->numed = $target_d_numed;
            $target_d->moneyed = $target_d_moneyed;
            $target_d->save();
        }
    }
    public function deleted($target_d)
    {
        TargetD::where('parent_d_id',$target_d->d_id)->delete();
    }
}