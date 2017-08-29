<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/14
 * Time: 10:25
 */

namespace App\Observer;



use App\Models\Input;

class TargetObserver
{
    public function created($target)
    {
        //目标相关的所有订单
        $inputs = Input::where('user_id', '=', \Front::user()->user_id)
            ->where('p_id', $target->p_id)
            ->whereBetween('created_at',[$target->s_time,$target->e_time])
            ->get();
        if ($inputs) {
            $target_numed = 0;
            $target_moneyed = 0.00;
            foreach ($inputs as $key => $input) {

                if ($input->input_status != 0 &&  $input->input_type == 'y') {
                    $target_numed = $target_numed + $input->num ;
                }
                if ($input->input_status != 0) {
                    $target_moneyed = $target_moneyed + $input->p_amount ;
                }
            }
            $target->numed = $target_numed;
            $target->moneyed = $target_moneyed;
            $target->save();
        }
    }
}