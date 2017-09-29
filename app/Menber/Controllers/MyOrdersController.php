<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/14
 * Time: 22:42
 */

namespace App\Menber\Controllers;


use App\Menber\Grid;
use App\Menber\Layout\Content;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Menber as MenberModel;
use App\Menber\Form;
use App\Models\Input;
use App\Models\Periodical;
use Illuminate\Routing\Controller;

class MyOrdersController extends Controller
{
    public function update($id)
    {
        return $this->form()->update($id);
    }

    public function index()
    {

        return \Menber::content(function (Content $content) {
            $content->header('发行管理系统');
            $content->description(config('menber.logo', config('menber.name')));
            $content->body($this->grid());

        });
    }


    protected function grid()
    {
        return \Menber::grid(Input::class, function (Grid $grid) {
            $grid->model()
                ->where('user_id', '=', \Menber::user()->user_id)
                ->where('u_id', '=', \Menber::user()->id)
                ->orderBy('id','desc');
            $grid->column('customer','客户')->display(function(){
                $customer_name =  Customer::where('id',$this->c_id)->value('name');
                if ($customer_name) {
                    return $customer_name;
                } else {
                    return $this->customer_name. '(已删除)' ;
                }
            });

            $grid->created_at('创建时间')->display(function(){
                return \Carbon::parse($this->created_at)->format('Y-m-d');
            });
            $grid->source('订单来源')->display(function(){
                return trans('menber::lang.source.' .$this->source. '');
            });

            $grid->column('d_id','部门')->display(function(){
                $department_name =  Department::where('id',$this->d_id)->value('name');
                return $department_name ? $department_name : $this->department_name. '(已删除)' ;
            });
            $grid->p_id('报刊名称')->display(function(){
                $periodical_name =  Periodical::where('id',$this->p_id)->value('name');
                return $periodical_name ? $periodical_name : $this->periodical_name. '(已删除)' ;
            });
            $grid->num('数量')->display(function(){
                return $this->num . '份';
            });
            $grid->input_type('订阅类别')->display(function(){
                return trans('menber::lang.input_type.' .$this->input_type. '');
            });
            $grid->ship_time('起始时间')->display(function(){
                return \Carbon::parse($this->ship_time)->format('Y-m-d');
            });
            $grid->p_amount('应付金额');
            $grid->money_paid('实付金额');
            $grid->piao_status('开票状态')->display(function(){
                return trans('menber::lang.piao_status.' .$this->piao_status. '');
            });
            $grid->column('pay','支付状态')->display(function(){
                return trans('menber::lang.pay_status.' .$this->pay_status. '');
            });
            $states = [
                'off'  => ['value' => 0, 'text' => '未确认', 'color' => 'primary'],
                'on' => ['value' => 1, 'text' => '已确认', 'color' => 'default'],
            ];

            $grid->column('input_status','订单状态')->switch($states);

//            $grid->rows(function($row){
//                //id小于10的行添加style
//                if($row->input_status == 0) {
//                    $row->style('color:red');
//                }
//            });
            $grid->filter(function($filter){
                $filter->useModal();
                $filter->disableIdFilter();

                $filter->is('piao_status', '开票状态')->select(trans('menber::lang.piao_status'));
                $filter->like('customer_name', '客户');
                $filter->is('p_id', '刊物')->select(
                    Periodical::where('user_id', \Menber::user()->user_id)
                        ->pluck('name', 'id')
                );
                $filter->like('fapiao', '发票');
                $filter->like('menber_name', '销售人');
                $filter->between('created_at', '下单时间')->datetime();
                $filter->like('d_id', '部门ID');
                // 关系查询，查询对应关系`department`的字段
                $filter->is('d_id', '所属部门')->select(Department::selectOptionsForNoroot(\Menber::user()->user_id));
                $filter->like('liushui', '流水号');
                $filter->is('pay_status', '支付状态')->select(trans('menber::lang.pay_status'));
            });
            $grid->disableActions();
            $grid->disableCreation();
            $grid->disableBatchDeletion();
        });
    }

    protected function form()
    {
        return \Menber::form(Input::class, function (Form $form) {



            $form->switch('input_status', '订单状态');

            $form->hidden('user_id')->default(\Menber::user()->user_id);

            $form->saving(function (Form $form){

            });
        });
    }
}