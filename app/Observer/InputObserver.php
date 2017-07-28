<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/17
 * Time: 16:48
 */

namespace App\Observer;

use App\Models\DTarget;
use App\Models\CheckDetail;
use App\Zhenggg\Auth\Database\Administrator;
use App\Zhenggg\Facades\Front;
use Illuminate\Support\Facades\DB;

class InputObserver
{
    public function saved($input)
    {
        if ($input->getOriginal('dis_status') == 0 && $input->dis_status ==1) {

            $check_detail = new CheckDetail;
            $check_detail->user_id = $input->user_id;
            $check_detail->u_id = $input->u_id;
            $check_detail->money = $input->should_dis_amount;
            $check_detail->save();

            Administrator::find($input->u_id)
                ->increment('money',$input->should_dis_amount);
        }


        Administrator::find($input->u_id)->roles->each(function ($role, $key) use ($input) {

            DB::table('inputs')->where('id',$input->id)
                ->update(['d_id' => $role->id]);
        });

        //当input saved时，如果订单确认状态发生改变，更新部门，个人已经完成目标

        if ($input->input_status != $input->getOriginal('input_status')) {
            $input->input_ps->each(function ($input_p, $key) use ($input) {
                if ($input->input_status == 1) {
                    DTarget::where('user_id', '=', Front::user()->id)
                        ->where('p_id', $input_p->p_id)
                        ->where('d_id', $input->d_id)
                        ->increment('numed',$input_p->num);
                } else {
                    DTarget::where('user_id', '=', Front::user()->id)
                        ->where('p_id', $input_p->p_id)
                        ->where('d_id', $input->d_id)
                        ->decrement('numed',$input_p->num);
                }

            });
        }
    }

    public function deleting()
    {

    }
}