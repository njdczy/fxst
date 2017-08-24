<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/18
 * Time: 17:42
 */

namespace App\Front\Controllers\Yeji;

use App\Front\Extensions\Action\JisuanAction;
use App\Models\Department;
use App\Models\Input;
use App\Models\Menber;


use App\Models\MenberPer;
use App\Models\Periodical;
use App\Models\Target;
use App\Models\UCheckout;
use App\Zhenggg\Grid;

use App\Zhenggg\Layout\Content;

use App\Zhenggg\Widgets\InfoBox;
use Illuminate\Routing\Controller;

class CheckoutController extends  Controller
{

    public function index()
    {
        return \Front::content(function (Content $content) {

            $content->header('业绩');
            $content->description('结算');
            $targets = Target::all();

            foreach ($targets as $key => $target) {

                if ($key%2==0) {
                    $content->row(function ($row) use ($target,$targets,$key) {
                        $row->column(2,'');
                        $row->column(3, new InfoBox($target->periodical->name, 'users', 'aqua',
                            \Front::url('checkout/p/'.$target->getKey()), '&nbsp;','详细'));
                        $row->column(1,'');
                        if ($targets->get($key+1)){
                            $row->column(3, new InfoBox($targets->get($key+1)->periodical->name, 'users', 'green',
                                \Front::url('checkout/p/'.$targets->get($key+1)->getKey()), '&nbsp;','详细'));
                        }
                        $row->column(2,'');
                    });
                }
            }
        });
    }

    public function checkoutIndex($t_id)
    {
        return \Front::content(function (Content $content) use ($t_id) {

            $content->header('业绩');
            $content->description('结算');
            $content->body($this->grid($t_id));
        });
    }

    protected function grid($t_id)
    {
        return \Front::grid(Menber::class, function (Grid $grid) use ($t_id) {
            $target = Target::find($t_id);

            //grid model filters
            $grid->model()->where('user_id', '=', \Front::user()->user_id);

            //grid columns
            $grid->column('name','发行人')->display(function(){
                $menber_name =  Menber::where('id',$this->id)->value('name');
                return $menber_name ? $menber_name : $this->menber_name. '(已删除)' ;
            });

            $grid->column('department.name','部门')->display(function () {
                $department = Department::where('id', $this->d_id)->first();
                if ($department->parent_id > 0) {
                    $parent_name = Department::where('id', $department->parent_id)->value('name');
                    return $department->name. '(' . $parent_name . ')';
                }
                return $department->name;
            })->label();

            $inputs = Input::where('user_id', '=', \Front::user()->user_id)
                ->where('p_id', $target->p_id)
                ->where('created_at', '>=', $target->s_time)
                ->where('created_at', '<=', $target->e_time)
                ->get();

            $grid->column('num','数量')->display(function () use ($inputs) {
                $filtered_inputs = $inputs->filter(function ($input, $key) {
                    return $input->u_id == $this->id;
                });
                $nums = ['m'=>0,'j'=>0,'b'=>0,'y'=>0];
                foreach ($filtered_inputs as $input) {
                    $nums[$input['input_type']] = $nums[$input['input_type']] + $input['num'];
                }
                $html = '';
                foreach ($nums as $key => $num) {
                    $html .= "<span>" . trans('front::lang.input_type.' .$key. '') . ":$num</span>&nbsp;&nbsp;&nbsp;";
                }
                return $html;
            });

            $p = $target->periodical;

            $grid->column('per','提成比例')->display(function () use ($p) {
                $p_pers = ['m'=>$p->per,'j'=>$p->per,'b'=>$p->per,'y'=>$p->per,];
                $pers = MenberPer::where('user_id', '=', \Front::user()->user_id)
                    ->where('menber_id', $this->id)
                    ->where('p_id', $p->id)
                    ->pluck('per', 'type')->toArray();
                $res_pers = array_merge($p_pers,$pers);
                $html = '';
                foreach ($res_pers as $key => $res_per) {
                    $html .= "<span>" . trans('front::lang.input_type.' .$key. '') . ":$res_per%</span>&nbsp;&nbsp;&nbsp;";
                }
                return $html;
            });

            $grid->column('should_shou_money','应收金额')->display(function () use ($inputs) {
                $filtered_inputs = $inputs->filter(function ($input, $key) {
                    return $input->u_id == $this->id;
                });
                $should_shou_money = 0;
                foreach ($filtered_inputs as $input) {
                    $should_shou_money = $should_shou_money + $input['p_amount'];
                }
                return $should_shou_money;
            });
            $grid->column('fact_shou_money','实收金额')->display(function () use ($inputs) {
                $filtered_inputs = $inputs->filter(function ($input, $key) {
                    return $input->u_id == $this->id;
                });
                $money_paid = 0;
                foreach ($filtered_inputs as $input) {
                    $money_paid = $money_paid + $input['money_paid'];
                }
                return $money_paid;
            });
            $grid->column('piao_money','开票金额')->display(function () use ($inputs) {
                $filtered_inputs = $inputs->filter(function ($input, $key) {
                    return $input->u_id == $this->id;
                });
                $piao_money = 0;
                foreach ($filtered_inputs as $input) {
                    $piao_money = $piao_money + $input['piao_money'];
                }
                return $piao_money;
            });
            $grid->column('kou_money','坐扣')->display(function () use ($inputs) {
                $filtered_inputs = $inputs->filter(function ($input, $key) {
                    return $input->u_id == $this->id;
                });
                $money_kou = 0;
                foreach ($filtered_inputs as $input) {
                    $money_kou = $money_kou + $input['money_kou'];
                }
                return $money_kou;
            });
            $grid->column('not_shou_money','未收金额')->display(function () use ($inputs) {
                $filtered_inputs = $inputs->filter(function ($input, $key) {
                    return $input->u_id == $this->id;
                });
                $money_weishou = 0;
                foreach ($filtered_inputs as $input) {
                    $money_weishou = $money_weishou + ($input['p_amount']-$input['money_paid']-$input['money_kou']);
                }
                return $money_weishou;
            });

            /**某个发行人某一种刊物应结算金额
             *  0.已经确认
             *  1.已经全部开票
             *  2.已经全部收款
             *    的订单
             * 每种时长的单价*每种时长的份数*每种时长的比例 - 坐扣之和
             *
             */

            $grid->column('jishuan_money','应结算金额');
            $grid->column('not_jishuan_money','未结算金额');
            $grid->column('j_status','发放状态')->display(function (){
                //return trans('front::lang.j_status.' .$j_status. '');
            });

            //grid actions
            $grid->actions(function ($actions) {
                $actions->disableDelete();
                $actions->disableEdit();
                $actions->append(new JisuanAction($actions->getKey()));
            });

            //grid tools
            $grid->disableExport();
            $grid->disableCreation();
            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            });

            //grid filters
            $grid->filter(function($filter){

                $filter->disableIdFilter();

                $filter->like('name', '姓名');

                $filter->is('d_id', '所属部门')->select(Department::selectOptionsForNoroot());

            });
        });
    }
}