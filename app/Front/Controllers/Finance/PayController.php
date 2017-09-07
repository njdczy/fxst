<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/18
 * Time: 13:16
 */

namespace App\Front\Controllers\Finance;

use App\Front\Extensions\Action\PayAction;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Input;

use App\Models\LiushuiLog;
use App\Models\Menber;
use App\Models\Periodical;

use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\MessageBag;

use Illuminate\Foundation\Validation\ValidatesRequests;

class PayController extends Controller
{
    use ValidatesRequests;

    public function index()
    {
        return \Front::content(function (Content $content) {

            $content->header('收款');
            $content->description('管理');

            $content->body($this->grid());
        });
    }
    protected function grid()
    {
        return \Front::grid(Input::class, function (Grid $grid) {

            //grid model filters
            $grid->model()->where('user_id', '=', \Front::user()->user_id)->orderBy('id', 'desc');

            //grid columns
            $grid->column('customer', '客户')->display(function () {
                $customer_name = Customer::where('id', $this->c_id)->value('name');
                if ($customer_name) {
                    return '<a href=" ' . \Front::url('customer') . '/' . $this->c_id . '/edit/"> ' . $customer_name . '</a>';
                } else {
                    return $this->customer_name . '(已删除)';
                }
            });
            $grid->u_id('发行人')->display(function () {
                $menber_name = Menber::where('id', $this->u_id)->value('name');

                return $menber_name ? $menber_name : $this->menber_name . '(已删除)';
            });
            $grid->column('d_id', '部门')->display(function () {
                $department_name = Department::where('id', $this->d_id)->value('name');

                return $department_name ? $department_name : $this->department_name . '(已删除)';
            });
            $grid->p_id('报刊名称')->display(function () {
                $periodical_name = Periodical::where('id', $this->p_id)->value('name');

                return $periodical_name ? $periodical_name : $this->periodical_name . '(已删除)';
            });
            $grid->num('数量')->display(function () {
                return $this->num . '份';
            });
            $grid->p_amount('应付金额');
            $grid->money_paid('实付金额');
            $grid->money_kou('坐扣');
            $grid->column('not_pay_money', '未付金额')->display(function () {
                return ($this->p_amount - $this->money_kou - $this->money_paid);
            });

            $grid->piao_status('支付状态')->display(function () {
                return trans('front::lang.pay_status.' . $this->pay_status . '');
            });

            //grid actions
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                $actions->disableEdit();

                $actions->append(new PayAction($actions->getKey(),$actions->row->pay_status));

            });

            //grid tools
            $grid->disableCreation();
            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            });

            //grid filters
            $grid->filter(function($filter){

                $filter->disableIdFilter();

                $filter->is('pay_status', '支付状态')->select(trans('front::lang.pay_status'));
                //$filter->like('customer_name', '客户');
                $filter->where(function ($query) {
                    $input = $this->input;
                    $query->whereHas('customer', function ($query) use ($input) {
                        $query->where('name', 'like', "%{$input}%");
                    });
                }, '客户');
                $filter->is('d_id', '所属部门')->select(Department::selectOptionsForNoroot());

                $filter->where(function ($query) {
                    $input = $this->input;
                    $query->whereHas('liushuis', function ($query) use ($input) {
                        $query->where('liushuihao', 'like', "%{$input}%");
                    });
                }, '流水号');
            });
        });
    }

    public function getDetail($input_id)
    {
        $input = Input::find($input_id);
        if ($input) {

            $liushuis = $input->liushuis->toArray();
            foreach ($liushuis as $key => $liushui)
            {
                $liushuis[$key]['key'] = "第".($key+1)."次收款";
                $liushuis[$key]['should_pay_money'] = $input->p_amount;
                $liushuis[$key]['pay_type'] = trans('front::lang.pay_name.' . $liushui['pay_type'] . '');
                $liushuis[$key]['liushuihao'] = $liushui['liushuihao']?:'';
                $liushuis[$key]['money'] = $liushui['money']?:0;
                $liushuis[$key]['kou'] = $liushui['kou']?:0;
                $liushuis[$key]['shou_time'] = \Carbon::parse($liushui['shou_time'])->format('Y-m-d');
            }
            $not_pay_money = ($input->p_amount-$input->money_kou-$input->money_paid);

            return response()->json([
                'status'  => true,
                'liushuis' => $liushuis,
                'not_pay_money' => $not_pay_money,
            ]);
        }
    }

    public function setDetail($input_id,Request $request)
    {
        $shi_pay_money_key = 'shi_pay_money' . $input_id;
        $kou_key = 'kou' . $input_id;
        $liushuihao_key = 'liushuihao' . $input_id;
        $paytype_key = 'paytype' . $input_id;
        $shou_time_key = 'shou_time' . $input_id;

        $shi_pay_money = $request->{$shi_pay_money_key};
        $kou = $request->{$kou_key};
        $liushuihao = $request->{$liushuihao_key};
        $paytype = $request->{$paytype_key};
        $shou_time = $request->{$shou_time_key};

        $input = Input::find($input_id);
        \DB::transaction(function () use ($shi_pay_money,$kou,$liushuihao,$paytype,$shou_time,$input) {
            $piao_log = new LiushuiLog;
            $piao_log->user_id = $input->user_id;
            $piao_log->input_id = $input->id;
            $piao_log->c_id = $input->c_id;
            $piao_log->menber_id = $input->u_id;
            $piao_log->money = $shi_pay_money;
            $piao_log->kou = $kou;
            $piao_log->liushuihao = $liushuihao;
            $piao_log->pay_type = $paytype;
            $piao_log->shou_time = $shou_time;
            $piao_log->save();

            $input->money_paid = $input->money_paid + $shi_pay_money;
            $input->money_kou = $input->money_kou + $kou;

            $input->input_status = 2;

            if ($input->money_paid == ($input->p_amount-$input->money_kou)) {
                $input->pay_status = 1;
                if ($input->piao_status == 1 || 2) {
                    $input->input_status = 3;
                }
            } else {
                $input->pay_status = 2;
            }
            $input->save();
        });
        $info = new MessageBag([
            'title'   => '收款成功',
            'message' => '',
        ]);
        return back()->with(compact('info'));
    }

    public function update($input_id,Request $request)
    {
        $liushui_log = LiushuiLog::find($request->pk);
        $input = Input::find($input_id);

        $edit_field = $request->name;
        if ($edit_field == 'liushuihao') {
            $this->validate($request,
                ['value' =>'bail|max:100'],
                [
                    'value.max' => '流水号太长',
                ]
            );
        }
        if ($edit_field == 'shou_time') {
            $this->validate($request,
                ['value' =>'bail|required|date'],
                [
                    'value.required' => '请输入时间',
                    'value.date' => '请按YYYY-MM-DD的格式输入时间',
                ]
            );
        }
        if ($edit_field == 'money') {
            $this->validate($request,
                ['value' =>
                    [
                        'bail',
                        'required',
                        'regex:/^(?!0(\\d|\\.0+$|$))\\d+(\\.\\d{1,2})?$/i',
                    ]

                ],
                [
                    'value.required' => '请输入金额',
                    'value.regex' => '请输入合法金额',
                ]
            );
            $input->money_paid = $input->money_paid + $request->value - $liushui_log->money;

            if ( $input->money_paid > ($input->p_amount-$input->money_kou)) {
                return response()
                    ->json([
                        'value' => ['金额不能大于'.($input->p_amount - $input->money_kou - $input->getOriginal('money_paid') + $liushui_log->money)]
                    ],422);
            }
            if ($input->money_paid == ($input->p_amount-$input->money_kou)) {
                $input->pay_status = 1;
                if ($input->piao_status == 1 || 2) {
                    $input->input_status = 3;
                }
            } else {
                $input->pay_status = 2;
            }
            $input->save();
        }

        if ($edit_field == 'kou') {
            $this->validate($request,
                ['value' =>
                    [
                        'bail',
                        'required',
                        'regex:/^(?!0(\\d|\\.0+$|$))\\d+(\\.\\d{1,2})?$/i',
                    ]

                ],
                [
                    'value.required' => '请输入金额',
                    'value.regex' => '请输入合法数字',
                ]
            );
            $input->money_kou = $input->money_kou + $request->value - $liushui_log->kou;

            if ( $input->money_kou > ($input->p_amount-$input->money_paid)) {
                return response()
                    ->json([
                        'value' => ['金额不能大于'.($input->p_amount - $input->money_paid - $input->getOriginal('money_kou') + $liushui_log->kou)]
                    ],422);
            }

            if ($input->money_paid == ($input->p_amount-$input->money_kou)) {
                $input->pay_status = 1;
                if ($input->piao_status == 1 || 2) {
                    $input->input_status = 3;
                }
            } else {
                $input->pay_status = 2;
            }

            $input->save();
        }

        $liushui_log->{$edit_field} = $request->value;
        $liushui_log->save();
    }
}