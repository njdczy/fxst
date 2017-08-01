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
            $check_detail->money = $input->money_paid * $input->dis_per;
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
            $input = Input::where('id',$input->id)
                ->first();
                //查出改订单的部门的上级部门，更新其上级部门的该刊物的目标
                if ($input->d_id) {
                    $d_id_array = [0,$input->d_id];
                    $parent = Department::find($input->d_id)->parent;
                    if ($parent) {
                        array_push($d_id_array,$parent->id);
                        $parent = Department::find($parent->id)->parent;
                        if ($parent) {
                            array_push($d_id_array,$parent->id);
                            $parent = Department::find($parent->id)->parent;
                            if ($parent) {
                                array_push($d_id_array,$parent->id);
                            }
                        }
                    }
                }
                if ($input->input_status == 1) {
                    Target::where('user_id', '=', Front::user()->user_id)
                        ->whereIn('d_id', $d_id_array)
                        ->where('p_id', $input->p_id)
                        ->increment('numed',$input->num);
                } else {
                    Target::where('user_id', '=', Front::user()->user_id)
                        ->whereIn('d_id', $d_id_array)
                        ->where('p_id', $input->p_id)
                        ->decrement('numed',$input->num);
                }

        }
    }

    public function deleting()
    {

    }
}