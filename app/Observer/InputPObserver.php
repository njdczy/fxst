<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/16
 * Time: 14:45
 */

namespace App\Observer;

use App\Models\Input;
use App\Models\InputP;

class InputPObserver
{
    public function saved($input_p)
    {
        //当input_p saved时，找出改订单下面所有的$input_ps，计算总额到input的应付总价格上
        $input_ps = InputP::where('input_id',$input_p->input_id)->get();

        $input_ps->each(function ($input_p, $key) {
            $input = Input::find($input_p->input_id);

            $input->p_amount = $input_p->num * $input_p->price;
            //todo should_dis_amount
            $input->save();
        });
    }
}