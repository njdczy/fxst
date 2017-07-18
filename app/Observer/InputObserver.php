<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/17
 * Time: 16:48
 */

namespace App\Observer;

use App\DTarget;
use App\Zhenggg\Auth\Database\Administrator;
use App\Zhenggg\Facades\Front;
use Illuminate\Support\Facades\DB;

class InputObserver
{
    public function saved($input)
    {
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
}