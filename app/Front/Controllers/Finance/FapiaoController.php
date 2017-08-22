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

class FapiaoController extends Controller
{
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
                return trans('app.piao_status.' . $this->piao_status . '');
            });

            //grid actions
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                $actions->disableEdit();

                $actions->append(new KaiPiaoAction($actions->getKey(),$actions->row->piao_status));

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

                $filter->is('piao_status', '开票状态')->select(trans('app.piao_status'));
                $filter->like('customer_name', '客户');
                $filter->is('d_id', '所属部门')->select(Department::selectOptionsForNoroot());

                $filter->where(function ($query) {
                    $input = $this->input;
                    $query->whereHas('fapiaos', function ($query) use ($input) {
                        $query->where('fapiaohao', 'like', "%{$input}%");
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
                $fapiaos[$key]['key'] = "第".($key+1)."开票";
                $fapiaos[$key]['should_kai_money'] = $input->p_amount;
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

        $shi_kai_money = $request->{$shi_kai_money_key};
        $fapiaohao = $request->{$fapiaohao_key};

        $input = Input::find($input_id);

        $piao_log = new PiaoLog;
        $piao_log->user_id = $input->user_id;
        $piao_log->input_id = $input_id;
        $piao_log->c_id = $input->c_id;
        $piao_log->admin_id = \Front::user()->id;
        $piao_log->kai_money = $shi_kai_money;
        $piao_log->haoma = $fapiaohao;
        $piao_log->save();

        $input->piao_money = $input->piao_money + $shi_kai_money;

        if ($input->piao_money == $input->p_amount) {
            $input->piao_status = 1;
        } else {
            $input->piao_status = 3;
        }
        $input->save();
    }
}