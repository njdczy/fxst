<?php

namespace App\Front\Controllers;

use App\Input;
use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use App\Zhenggg\Facades\Front;
use App\Zhenggg\Layout\Content;
use App\Zhenggg\Controllers\ModelForm;
use Illuminate\Routing\Controller;

class InputController extends Controller
{
    use ModelForm;

    public function index()
    {
        return Front::content(function (Content $content) {

            $content->header('订单');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return Front::content(function (Content $content) use ($id) {

            $content->header('订单');
            $content->description('修改');

            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return Front::content(function (Content $content) {

            $content->header('订单');
            $content->description('录入');

            $content->body($this->form());
        });
    }

    protected function grid()
    {
        return Front::grid(Input::class, function (Grid $grid) {
            $grid->c_id('客户');
            $grid->source('订单来源');
            $grid->input_status('订单状态');
            $grid->pay_status('支付状态');
            $grid->column('input_ps','订单详情');
            $grid->p_amount('应付总金额');
            $grid->money_paid('已付款金额');
            $grid->pay_note('付款备注');
        });
    }

    protected function form()
    {
        return Front::form(Input::class, function (Form $form) {


            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}