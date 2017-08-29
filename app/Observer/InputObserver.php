<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/17
 * Time: 16:48
 */

namespace App\Observer;

use App\Models\CheckDetail;

use App\Models\Input;
use App\Models\Menber;
use App\Models\Target;
use App\Models\TargetM;



class InputObserver
{

    private function update_target($input,$money_type = 'add_money',$num_type = '')
    {
        //总目标
        $targets = Target::where('user_id', '=', \Front::user()->user_id)
            ->where('p_id', $input->p_id)
            ->where('s_time', '<',$input->created_at)
            ->where('e_time', '>',$input->created_at)
            ->get();
        $targets->each(function($target,$key) use ($input,$money_type,$num_type) {
            if ($money_type == 'add_money') {
                $target->moneyed = $target->moneyed + $input->p_amount;
            } else if ($money_type == 'jian_money') {
                $target->moneyed = $target->moneyed - $input->p_amount;
            }

            if ($num_type == 'add_num') {
                $target->numed = $target->numed + $input->num;
            } else if ($num_type == 'jian_num') {
                $target->numed = $target->numed - $input->num;
            }

            $target->save();

            //每个总目标下面的部门目标
            $target_ds = $target->targetds;
            $target_ds->each(function($target_d,$key) use ($input,$target,$money_type,$num_type) {
                if ($money_type == 'add_money') {
                    $target_d->moneyed = $target_d->moneyed + $input->p_amount;
                } else if ($money_type == 'jian_money') {
                    $target_d->moneyed = $target_d->moneyed - $input->p_amount;
                }
                if ($num_type == 'add_num') {
                    $target_d->numed = $target_d->numed + $input->num;
                } else if ($num_type == 'jian_num') {
                    $target_d->numed = $target_d->numed - $input->num;
                }
                $target_d->save();
                //个人目标
                $target_m = TargetM::firstOrNew([
                    'user_id' => \Front::user()->user_id,
                    'user_name' => $input->menber_name,
                    'u_id' => $input->u_id,
                    't_id' => $target->id,
                    't_d_id' => $target_d->id,
                ]);
                if ($money_type == 'add_money') {
                    $target_m->moneyed = $target_m->moneyed + $input->p_amount;
                } else if ($money_type == 'jian_money') {
                    $target_m->moneyed = $target_m->moneyed - $input->p_amount;
                }
                if ($num_type == 'add_num') {
                    $target_m->numed = $target_m->numed + $input->num;
                } else if ($num_type == 'jian_num') {
                    $target_m->numed = $target_m->numed - $input->num;
                }
            });
        });
    }

    public function created($input)
    {
        if ($input->input_status == 1 && $input->input_type == 'y'){
            $this->update_target($input);
        }
    }
    public function updated($input)
    {
        //当分成，增家余额

        //当input saved时，如果订单确认状态发生改变，更新所有该刊物下面的目标
        if ($input->input_status != $input->getOriginal('input_status')){
            if ($input->input_status == 1 ) {
                if ($input->input_type == 'y') {
                    $this->update_target($input,'add_money','add_num'); //更新目标金额和数量
                } else {
                    $this->update_target($input,'add_money');//更新目标金额
                }

            } elseif ($input->input_status == 0) {
                if ($input->input_type == 'y') {
                    $this->update_target($input,'jian_money','jian_num'); //更新目标金额和数量
                } else {
                    $this->update_target($input,'jian_money');//更新目标金额
                }
            }
        }
    }

    public function deleted($input)
    {
        foreach ($input->fapiaos as $fapiao) {
            $fapiao->delete();
        }
        foreach ($input->liushuis as $liushui) {
            $liushui->delete();
        }
    }

}