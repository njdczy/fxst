<?php


namespace App\Front\Controllers\Finance;


use App\Front\Extensions\Action\KaiPiaoAction;


use App\Models\Customer;
use App\Models\Department;
use App\Models\Input;

use App\Models\Menber;
use App\Models\Periodical;
use App\Models\PiaoLog;

use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\MessageBag;

use Illuminate\Foundation\Validation\ValidatesRequests;

class FapiaoController extends Controller
{
    use ValidatesRequests;
    public function index()
    {
        return \Front::content(function (Content $content) {

            $content->header('发票');
            $content->description('管理');

            $content->body($this->grid());
        });
    }
    protected function grid()
    {
        return \Front::grid(Input::class, function (Grid $grid) {
            //grid model filters
            $grid->model()
                ->where('user_id', '=', \Front::user()->user_id)
                ->whereIn('input_status', array_keys(array_except(trans('front::lang.input_status'),'0')))
                ->orderBy('id', 'desc');

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
            $grid->piao_money('已开金额');
            $grid->column('not_piao_money', '未开金额')->display(function () {
                return ($this->p_amount - $this->piao_money);
            });
            $grid->column('fapiao', '发票号')->display(function () {
                $piao_logs =  PiaoLog::where('user_id', \Front::user()->user_id)
                    ->where('input_id',$this->id)
                    ->pluck('haoma', 'id');
                $html = '';
                foreach ($piao_logs as $piao_log) {
                    $html .= $piao_log .',';
                }
                return $html;
            });
            $grid->piao_status('开票状态')->display(function () {
                return trans('front::lang.piao_status.' . $this->piao_status . '');
            });

            //grid actions
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                $actions->disableEdit();
                //无需开票
                if ($actions->row->piao_status != 2) {
                    $actions->append(new KaiPiaoAction($actions->getKey(),$actions->row->piao_status));
                }
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

                $filter->is('piao_status', '开票状态')->select(trans('front::lang.piao_status'));


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
                    $query->whereHas('fapiaos', function ($query) use ($input) {
                        $query->where('haoma', 'like', "%{$input}%");
                    });
                }, '发票号');
            });
        });
    }

    public function getDetail($input_id)
    {
        $input = Input::find($input_id);
        if ($input->customer) {
            $customer_piao = $input->customer->customer_piao->toArray();
            if (!$customer_piao) {
                $info = new MessageBag([
                    'title'   => '请先添加该客户的开票信息',
                    'message' => '',
                ]);
                return redirect()->to(\Front::url('customer/'.$input->c_id.'/edit'))->with(compact('info'));
            }
            $fapiaos = $input->fapiaos->toArray();
            foreach ($fapiaos as $key => $fapiao)
            {
                $fapiaos[$key]['key'] = "第".($key+1)."次开票";
                $fapiaos[$key]['should_kai_money'] = $input->p_amount;
                $fapiaos[$key]['haoma'] = $fapiao['haoma']?:'';
                $fapiaos[$key]['kai_time'] = \Carbon::parse($fapiao['kai_time'])->format('Y-m-d');
            }
            $not_kai_money = ($input->p_amount-$input->piao_money);
            return response()->json([
                'status'  => true,
                'customer_piao' => $customer_piao,
                'fapiaos' => $fapiaos,
                'not_kai_money' => $not_kai_money,
            ]);
        }
    }

    public function setDetail($input_id,Request $request)
    {
        $shi_kai_money_key = 'shi_kai_money' . $input_id;
        $fapiaohao_key = 'fapiaohao' . $input_id;
        $kai_time_key = 'kai_time' . $input_id;

        $shi_kai_money = $request->{$shi_kai_money_key};
        $fapiaohao = $request->{$fapiaohao_key};
        $kai_time = $request->{$kai_time_key};

        $input = Input::find($input_id);
        \DB::transaction(function () use ($shi_kai_money,$fapiaohao,$kai_time,$input) {
            $piao_log = new PiaoLog;
            $piao_log->user_id = $input->user_id;
            $piao_log->input_id = $input->id;
            $piao_log->c_id = $input->c_id;
            $piao_log->admin_id = \Front::user()->id;
            $piao_log->kai_money = $shi_kai_money;
            $piao_log->haoma = $fapiaohao;
            $piao_log->kai_time = $kai_time;
            $piao_log->save();

            $input->piao_money = $input->piao_money + $shi_kai_money;

            $input->input_status = 2;

            if ($input->piao_money == $input->p_amount) {
                $input->piao_status = 1;
                if ($input->pay_status == 1) {
                    $input->input_status = 3;
                }
            } else {
                $input->piao_status = 3;
            }
            $input->save();
        });
        $info = new MessageBag([
            'title'   => '开票成功',
            'message' => '',
        ]);
        return back()->with(compact('info'));

    }

    public function update($input_id,Request $request)
    {
        $piao_log = PiaoLog::find($request->pk);
        $input = Input::find($input_id);

        $edit_field = $request->name;
        if ($edit_field == 'haoma') {
            $this->validate($request,
                ['value' =>'bail|required|max:50'],
                [
                    'value.required' => '请输入发票号',
                ]
            );
        }
        if ($edit_field == 'kai_time') {
            $this->validate($request,
                ['value' =>'bail|required|date'],
                [
                    'value.required' => '请输入时间',
                    'value.date' => '请按YYYY-MM-DD的格式输入时间',
                ]
            );
        }

        if ($edit_field == 'kai_money') {
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

            $not_kai_money = ($input->p_amount-$input->piao_money+$piao_log->kai_money);
            if ($request->value > $not_kai_money) {
                return response()
                    ->json([
                        'value' => ['金额不能大于'.$not_kai_money]
                    ],422);
            }

            $input->piao_money = $input->piao_money - $piao_log->kai_money + $request->value;

            if ($input->piao_money == $input->p_amount) {
                $input->piao_status = 1;
                if ($input->pay_status == 1) {
                    $input->input_status = 3;
                }
            } else {
                $input->piao_status = 3;
            }
            $input->save();
        }

        $piao_log->{$edit_field} = $request->value;
        $piao_log->save();


    }
}