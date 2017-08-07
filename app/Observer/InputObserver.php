<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/17
 * Time: 16:48
 */

namespace App\Observer;

use App\Models\CheckDetail;
use App\Models\Department;
use App\Models\Input;
use App\Models\Menber;
use App\Models\Target;
use App\Models\TargetM;
use App\Zhenggg\Facades\Front;
use Illuminate\Support\Facades\DB;


class InputObserver
{
    public function saved($input)
    {
        //当分成，增家余额
        if ($input->getOriginal('dis_status') == 0 && $input->dis_status ==1) {

            $check_detail = new CheckDetail;
            $check_detail->user_id = $input->user_id;
            $check_detail->u_id = $input->u_id;
            $check_detail->money = $input->money_paid * $input->dis_per/100;
            $check_detail->save();

            Menber::find($input->u_id)
                ->increment('money',$check_detail->money);
        }
        //当input save ，如果订单的销售改变，更新订单的部门
        $department = Menber::find($input->u_id)->department;

        Input::where('id',$input->id)
            ->update(['d_id' => $department->id]);

        //当input saved时，如果订单确认状态发生改变，更新所有该刊物下面的目标

        if ($input->input_status != $input->getOriginal('input_status')) {
            $now_input = Input::where('id',$input->id)
                ->first();
                if ($now_input->input_status == 1) {
                    //总目标
                    $targets = Target::where('user_id', '=', Front::user()->user_id)
                        ->where('p_id', $now_input->p_id)
                        ->where('s_time', '<',$now_input->created_at)
                        ->where('e_time', '>',$now_input->created_at)
                        ->get();

                    $targets->each(function($target,$key) use ($now_input) {
                        $target->numed = $target->numed + $now_input->num;
                        $target->save();
                        //每个总目标下面的部门目标
                        $target_ds = $target->targetds;
                        $target_ds->each(function($target_d,$key) use ($now_input,$target) {
                            $target_d->numed = $target_d->numed + $now_input->num;
                            $target_d->save();
                            //个人目标
                            $target_m = TargetM::firstOrNew([
                                'user_id' => Front::user()->user_id,
                                'user_name' => $now_input->menber_name,
                                'u_id' => $now_input->u_id,
                                't_id' => $target->id,
                                't_d_id' => $target_d->id,
                            ]);
                            $target_m->numed = $target_m->numed + $now_input->num;
                        });
                    });
                } else if ($input->getOriginal('input_status') != null){
                    //总目标
                    $targets = Target::where('user_id', '=', Front::user()->user_id)
                        ->where('p_id', $now_input->p_id)
                        ->where('s_time', '<',$now_input->created_at)
                        ->where('e_time', '>',$now_input->created_at)
                        ->get();
                    $targets->each(function($target,$key) use ($now_input) {
                        $target->numed = $target->numed - $now_input->num;
                        $target->save();
                        //每个总目标下面的部门目标
                        $target_ds = $target->targetds;
                        $target_ds->each(function($target_d,$key) use ($now_input,$target) {
                            $target_d->numed = $target_d->numed - $now_input->num;
                            $target_d->save();
                            //个人目标
                            $target_m = TargetM::firstOrNew([
                                'user_id' => Front::user()->user_id,
                                'user_name' => $now_input->menber_name,
                                'u_id' => $now_input->u_id,
                                't_id' => $target->id,
                                't_d_id' => $target_d->id,
                            ]);
                            $target_m->numed = $target_m->numed - $now_input->num;
                        });
                    });
                }

        }
    }

    public function deleting()
    {

    }
}