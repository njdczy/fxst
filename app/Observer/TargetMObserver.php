<?php


namespace App\Observer;


use App\Models\Input;

class TargetMObserver
{
    public function created($target_m)
    {
        //目标相关的所有订单
        $inputs = Input::where('user_id', '=', \Front::user()->user_id)
            ->where('p_id', $target_m->p_id)
            ->where('u_id', $target_m->u_id)
            ->whereBetween('created_at',[$target_m->s_time,$target_m->e_time])
            ->get();
        if ($inputs) {
            $target_m_numed = 0;
            $target_m_moneyed = 0.00;
            foreach ($inputs as $key => $input) {
                if ($input->input_status == 1 &&  $input->input_type == 'y') {
                    $target_m_numed = $target_m_numed + $input->num ;
                }
                if ($input->input_status == 1) {
                    $target_m_moneyed = $target_m_moneyed + $input->p_amount ;
                }
            }
            $target_m->numed = $target_m_numed;
            $target_m->moneyed = $target_m_moneyed;
            $target_m->save();
        }
    }
}