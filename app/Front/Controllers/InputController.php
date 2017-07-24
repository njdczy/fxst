<?php

namespace App\Front\Controllers;

use App\Customer;
use App\Input;
use App\Periodical;
use App\Zhenggg\Auth\Database\Administrator;
use App\Zhenggg\Auth\Database\Role;
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
            $grid->model()->where('user_id', '=', Front::user()->user_id)->orderBy('id','desc');
            $grid->c_id('客户')->display(function(){
                return Customer::find($this->c_id)->value('name');
            });

            $grid->column('sale','销售人/所属部门')->display(function(){
                return Administrator::where('id',$this->u_id)->value('username'). '/' . Role::where('id',$this->d_id)->value('name');
            });

            $grid->source('订单来源')->display(function(){
                return trans('app.pay_source.' .$this->source. '');
            });
            $grid->column('input','订单状态/创建时间')->display(function(){
                return trans('app.input_status.' .$this->input_status. '') . '/' . $this->created_at;
            });

            $grid->column('pay','支付状态/支付方式')->display(function(){
                return trans('app.pay_status.' .$this->pay_status. '') . '/' . trans('app.pay_name.' .$this->pay_name. '');
            });

            $grid->column('input_ps','订单详情')->display(function(){
                $input_ps = Input::find($this->id)->input_ps->toArray();
                $html = '';
                foreach ($input_ps as $input_p) {
                    $html .=  Periodical::find($input_p['p_id'])->value('name') . ":" .$input_p['num'] .'份';
                }
                return $html;
            });;
            $grid->p_amount('应付总金额');

            $grid->money_paid('已付款金额');
            $grid->pay_note('付款备注');
        });
    }

    protected function form()
    {
        return Front::form(Input::class, function (Form $form) {
            $form->select('c_id', '客户')->options(
                Customer::where('user_id', Front::user()->user_id)
                    ->pluck('name', 'id')
            );
//
//            $form->select('d_id', '部门')->options(
//                Role::where('user_id', Front::user()->user_id)
//                    ->pluck('name', 'id')
//            )->load('u_id', '/front/api/input/u');

            $form->select('u_id', '销售')->options(
                Administrator::where('user_id', Front::user()->user_id)
                    ->pluck('username', 'id')
            )->rules('required');

            $form->select('source', '订单来源')->options(
               ['线下','微信']
            );
            $form->radio('input_status', '订单状态')->options([0 => '未确认', 1=> '已确认'])->default($form->input_status);
            $form->radio('pay_status', '支付状态')->options([0 => '未支付',1 => '已支付', 2=> '部分付款'])->default($form->pay_status);
            $form->select('pay_name', '支付方式')->options(
                ['线下','微信']
            );

            $form->hasMany('input_ps', '订单详情',function (Form\NestedForm $form) {
                $form->select('p_id','刊物')->options(
                    Periodical::where('user_id', Front::user()->user_id)
                        ->pluck('name', 'id')
                );
                $form->number('num','数量');
                $form->number('price','单价')->default(0);
            });
//            $form->saving(function (Form $form){
                //unset($form->u_id);
//                $u_id = Administrator::where('username',$form->u_id)->value('id');
//                $form->u_id = $u_id;
//            });

            $form->divide();

            $form->hidden('user_id')->default(Front::user()->user_id);
            $form->number('money_paid', '已付款金额');
            $form->text('pay_note', '付款备注');

        });
    }
}