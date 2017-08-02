<?php

namespace App\Front\Controllers\Finance;

use App\Models\Customer;
use App\Models\Department;
use App\Models\Input;
use App\Models\Menber;
use App\Models\Periodical;

use App\Models\Zhifu;
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
                return Customer::where('id',$this->c_id)->value('name');
            });

            $grid->column('sale','销售人/所属部门')->display(function(){
                $menber_name =  Menber::where('id',$this->u_id)->value('name');

                if ($menber_name) {
                    return $menber_name. '/' . Department::where('id',$this->d_id)->value('name');
                } else {
                    return $this->menber_name. '(已删除)' ;
                }

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
                $html =  Periodical::where('id',$this->p_id)->value('name') . ":" .$this->num .'份';
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
            $form->tab('1.客户信息', function ($form) {
                $form->select('c_id', '客户')->options(
                    Customer::where('user_id', Front::user()->user_id)
                        ->pluck('name', 'id')
                )->rules('required')->setWidth('4');
                $form->select('u_id', '销售')->options(
                    Menber::where('user_id', Front::user()->user_id)
                        ->pluck('name', 'id')
                )->rules('required')->setWidth('4');

                $form->select('source', '订单来源')->options(
                    ['后台添加','微信']
                )->setWidth('4');

                $form->select('input_status', '订单状态')->options(
                    [0 => '未确认',1 => '已确认']
                )->default($form->input_status)->setWidth('4');
                $form->divide();

            })->tab('2.订单信息', function ($form) {
                $form->select('p_id','刊物')->options(
                    Periodical::where('user_id', Front::user()->user_id)
                        ->pluck('name', 'id')
                )->setWidth('4')->rules('required');
                $form->number('num','数量')->rules('required');

            })->tab('3.款项信息', function ($form) {

                $form->number('money_paid', '已付款金额')->help('未付款填0');
                $form->select('pay_status', '支付状态')->options([0 => '未支付',1 => '已支付', 2=> '部分付款'])->default($form->pay_status)->setWidth('4');
                $form->select('pay_name', '支付方式')->options(
                    Zhifu::where('user_id', Front::user()->user_id)
                        ->orWhere('user_id', '=', 0)
                        ->pluck('name', 'id')
                )->setWidth('4');
                $form->text('pay_note', '付款备注');
                $form->divide();
                $form->hidden('user_id')->default(Front::user()->user_id);
                $form->hidden('menber_name');
                $form->hidden('dis_per');
                $form->hidden('p_name');
                $form->hidden('p_money');
                $form->hidden('p_amount');
            });

            $form->saving(function (Form $form){
                $menber_name =  Menber::where('id',$form->u_id)->value('name');
                $periodical =  Periodical::where('id',$form->p_id)->first();
                $form->menber_name = $menber_name;
                $form->p_name = $periodical->name;
                $form->dis_per = $periodical->per;
                $form->p_money = $periodical->c_price != 0? $periodical->c_price:$periodical->price;
                $form->p_amount = ($form->num * $form->p_money);
            });

        });
    }
}