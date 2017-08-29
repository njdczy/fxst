<?php

namespace App\Front\Controllers\Finance;

use App\Models\Customer;
use App\Models\Department;
use App\Models\Input;
use App\Models\Menber;
use App\Models\Periodical;

use App\Models\Type;
use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Content;
use App\Zhenggg\Controllers\ModelForm;
use Illuminate\Routing\Controller;

class InputController extends Controller
{
    use ModelForm;

    public function index()
    {
        return \Front::content(function (Content $content) {

            $content->header('订单');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return \Front::content(function (Content $content) use ($id) {

            $content->header('订单');
            $content->description('修改');

            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return \Front::content(function (Content $content) {

            $content->header('订单');
            $content->description('录入');

            $content->body($this->form());
        });
    }

    protected function grid()
    {
        return \Front::grid(Input::class, function (Grid $grid) {
            $grid->model()->where('user_id', '=', \Front::user()->user_id)->orderBy('id','desc');
            $grid->column('customer','客户')->display(function(){
                $customer_name =  Customer::where('id',$this->c_id)->value('name');
                if ($customer_name) {
                    return '<a href=" '. \Front::url('customer') .'/'.$this->c_id .'/edit/"> '.$customer_name.'</a>';
                } else {
                    return $this->customer_name. '(已删除)' ;
                }
            });

            $grid->created_at('创建时间')->display(function(){
                return \Carbon::parse($this->created_at)->format('Y-m-d');
            });
            $grid->source('订单来源')->display(function(){
                return trans('front::lang.source.' .$this->source. '');
            });
            $grid->u_id('发行人')->display(function(){
                $menber_name =  Menber::where('id',$this->u_id)->value('name');
                return $menber_name ? $menber_name : $this->menber_name. '(已删除)' ;
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
                return trans('front::lang.input_type.' .$this->input_type. '');
            });
            $grid->ship_time('起始时间')->display(function(){
                return \Carbon::parse($this->ship_time)->format('Y-m-d');
            });
            $grid->p_amount('应付金额');
            $grid->money_paid('实付金额');
            $grid->piao_status('开票状态')->display(function(){
                return trans('front::lang.piao_status.' .$this->piao_status. '');
            });
            $grid->column('pay','支付状态')->display(function(){
                return trans('front::lang.pay_status.' .$this->pay_status. '');
            });

            $grid->column('input','订单状态')->display(function(){
                return trans('front::lang.input_status.' .$this->input_status. '');
            });


            $grid->filter(function($filter){
                $filter->useModal();
                $filter->disableIdFilter();

                $filter->is('piao_status', '开票状态')->select(trans('front::lang.piao_status'));
                $filter->like('customer_name', '客户');
                $filter->like('fapiao', '发票');
                $filter->like('menber_name', '销售人');
                $filter->between('created_at', '下单时间')->datetime();
                $filter->like('d_id', '部门ID');
                // 关系查询，查询对应关系`department`的字段
                $filter->is('d_id', '所属部门')->select(Department::selectOptionsForNoroot());
                $filter->like('liushui', '流水号');
                $filter->is('pay_status', '支付状态')->select(trans('front::lang.pay_status'));
            });
        });
    }

    protected function form()
    {
        return \Front::form(Input::class, function (Form $form) {


            /*
            $form->tab('1.客户信息', function ($form) {
                $form->html(view('front::zhenggg.backandnextjs',['max'=>4]), '');
                $form->select('c_id', '客户')->options(
                    Customer::where('user_id', \Front::user()->user_id)
                        ->pluck('name', 'id')
                )->rules('required')->setWidth('4');
                $form->select('u_id', '销售')->options(
                    Menber::where('user_id', \Front::user()->user_id)
                        ->pluck('name', 'id')
                )->rules('required')->setWidth('4');
                $form->select('source', '订单来源')->options(
                    trans('front::lang.source')
                )->setWidth('4');

                $form->select('input_status', '订单状态')->options(
                    trans('front::lang.input_status')
                )->default($form->input_status)->help('当订单状态设为已确认时，将计入目标数')->rules('required')->setWidth('4');
                $form->divide();
                $form->html(view('front::zhenggg.backandnext',['which'=>1,'is_last'=>false]), '');

            })->tab('2.订单信息', function ($form) {
                $form->select('p_id','刊物')->options(
                    Periodical::where('user_id', \Front::user()->user_id)
                        ->pluck('name', 'id')
                )->setWidth('4')->rules('required');

                $form->select('input_type','订阅时长')->options(trans('front::lang.input_type'))->rules('required')->setWidth('4');
                $form->number('num','数量')->rules('required|min:1');
                $form->text('p_money','单价')->attribute(['readonly' => 'readonly'])->placeholder(' ')->setWidth('4');

                $form->html(view('front::zhenggg.inputselect'));

                $form->text('money_paid', '已付款金额')->help('未付款填0')->rules('required|numeric')->setWidth('4');
                $form->select('pay_status', '支付状态')->options(trans('front::lang.pay_status'))->default($form->pay_status)->setWidth('4');
                $form->divide();
                $form->html(view('front::zhenggg.backandnext',['which'=>2,'is_last'=>false]), '');

            })->tab('3.款项信息', function ($form) {

                $form->select('pay_name', '支付方式')->options(
                    Type::whereIn ('user_id', [\Front::user()->user_id,0])
                        ->where('type', '=', 'pay_type')
                        ->pluck('name', 'id')
                )->setWidth('4');
                $form->text('liushui','流水号')->setWidth('4');
                $form->text('pay_note', '付款备注');
                $form->divide();
                $form->hidden('user_id')->default(\Front::user()->user_id);
                $form->hidden('menber_name');
                $form->hidden('customer_name');
                $form->hidden('dis_per');
                $form->hidden('p_name');
                $form->hidden('p_money');
                $form->hidden('p_amount');
                $form->divide();
                $form->html(view('front::zhenggg.backandnext',['which'=>3,'is_last'=>false]), '');
            })->tab('4.开票信息', function ($form) {
                $form->select('piao_status', '开票状态')->options(trans('front::lang.piao_status'))->default($form->piao_status)->setWidth('4');
                $form->text('fapiao','发票号')->setWidth('4');
                $form->text('piao_money','开票金额')->rules('required|numeric')->setWidth('2');
                $form->divide();
                $form->html(view('front::zhenggg.backandnext',['which'=>4,'is_last'=>true]), '');
            });*/

            $form->select('c_id', '客户')->options(
                Customer::where('user_id', \Front::user()->user_id)
                    ->pluck('name', 'id')
            )->rules('required')->setWidth('4');
            $form->select('u_id', '销售')->options(
                Menber::where('user_id', \Front::user()->user_id)
                    ->pluck('name', 'id')
            )->rules('required')->setWidth('4');
            $form->select('source', '订单来源')->options(
                trans('front::lang.source')
            )->setWidth('4');

            $form->select('input_status', '订单状态')->options(
                trans('front::lang.input_edit_status')
            )->default($form->input_status)->help('当订单状态设为已确认时，将计入目标数')->rules('required')->setWidth('4');
            $form->divide();

            $form->select('p_id','刊物')->options(
                Periodical::where('user_id', \Front::user()->user_id)
                    ->pluck('name', 'id')
            )->setWidth('4')->rules('required');

            $form->date('ship_time','起始时间')->rules('required');


            $form->select('input_type','订阅时长')->options(trans('front::lang.input_type'))->rules('required')->setWidth('4');
            $form->number('num','数量')->rules('numeric|min:1');

            $id = preg_replace('/\D/s', '', request()->url());
            if ($id) {
                $input = Input::find($id);
            }
            if (isset($input)) {
                if (in_array($input->piao_status,[0,2])) {
                    $form->radio('piao_status','是否开票')->options([0=> '是',2 => '否'])->default(0);
                } else {
                    $form->display('是否开票')->default('是')->setWidth('1');
                }
            } else {
                $form->radio('piao_status','是否开票')->options([0=> '是',2 => '否'])->default(0);

            }


            $form->divide();
            $form->hidden('user_id')->default(\Front::user()->user_id);
            $form->hidden('menber_name');
            $form->hidden('customer_name');
            $form->hidden('dis_per');
            $form->hidden('p_name');
            $form->hidden('p_money');
            $form->hidden('p_amount');
            $form->hidden('d_id');
            $form->divide();
            $form->saving(function (Form $form){
                $menber_name =  Menber::where('id',$form->u_id)->value('name');
                $customer_name =  Customer::where('id',$form->c_id)->value('name');
                $periodical =  Periodical::where('id',$form->p_id)->first();
                $form->menber_name = $menber_name;
                $form->customer_name = $customer_name;
                $form->p_name = $periodical->name;
                $form->dis_per = $periodical->per;
                $p_key = $form->input_type . '_price';
                $form->p_money = $periodical->{$p_key};
                $form->p_amount = ($form->num * $form->p_money);

                //当input save ，如果订单的销售改变，更新订单的部门
                $department = Menber::find($form->u_id)->department;
                $form->d_id = $department->id;
            });
        });
    }

    public function destroy($id)
    {
        $ids = explode(',', $id);
        foreach ($ids as $id) {
            if (empty($id)) {
                continue;
            }
            $input = Input::find($id);
            if ($input) {
                if ($input->piao_status ==  1 && $input->pay_status == 1) {
                    return response()->json([
                        'status'  => false,
                        'message' => '订单已经完成，不能删除',
                    ]);
                }
            }
        }

        if ($this->form()->destroy($id)) {
            return response()->json([
                'status'  => true,
                'message' => trans('front::lang.delete_succeeded'),
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => trans('front::lang.delete_failed'),
            ]);
        }
    }
    public function selectp()
    {
        $p_id = request('p_id',0);
        $periodical = Periodical::find($p_id)->toArray();
        if ($periodical) {
            return response()->json($periodical);
        }
    }
}