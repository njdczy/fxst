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
use App\Models\Target;
use App\Models\UCheckout;
use App\Zhenggg\Grid;

use App\Zhenggg\Layout\Content;

use App\Zhenggg\Widgets\InfoBox;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\MessageBag;

class CheckoutController extends Controller
{
    use ValidatesRequests;
    public function index()
    {
        return \Front::content(function (Content $content) {

            $content->header('业绩');
            $content->description('结算');
            $targets = Target::all();

            foreach ($targets as $key => $target) {

                if ($key % 2 == 0) {
                    $content->row(function ($row) use ($target, $targets, $key) {
                        $row->column(2, '');
                        $date = \Carbon::parse($target->s_time)->format('Y-m-d') .
                            '--' . \Carbon::parse($target->e_time)->format('Y-m-d');

                        $row->column(3, new InfoBox($date, 'users', 'aqua',
                            \Front::url('checkout/p/' . $target->getKey()),
                            $target->periodical->name, '详细'));
                        $row->column(1, '');
                        if ($targets->get($key + 1)) {
                            $date = \Carbon::parse($targets->get($key + 1)->s_time)->format('Y-m-d') .
                                '--' . \Carbon::parse($targets->get($key + 1)->e_time)->format('Y-m-d');

                            $row->column(3, new InfoBox($date, 'users', 'green',
                                \Front::url('checkout/p/' . $targets->get($key + 1)->getKey()),
                                $targets->get($key + 1)->periodical->name, '详细'));
                        }
                        $row->column(2, '');
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
        $target = Target::find($t_id);

        $inputs = $this->get_inputs_by_target_model($target);

        $p = $target->periodical;

        return \Front::grid(Menber::class, function (Grid $grid) use ($target, $inputs, $p) {

            //grid model filters
            $grid->model()->where('user_id', '=', \Front::user()->user_id);

            //grid columns
            $grid->column('name', '发行人')->display(function () {
                $menber_name = Menber::where('id', $this->id)->value('name');
                return $menber_name ? $menber_name : $this->menber_name . '(已删除)';
            });

            $grid->column('department.name', '部门')->display(function () {
                $department = Department::where('id', $this->d_id)->first();
                if ($department->parent_id > 0) {
                    $parent_name = Department::where('id', $department->parent_id)->value('name');
                    return $department->name . '(' . $parent_name . ')';
                }
                return $department->name;
            })->label();

            $grid->column('num', '数量')->display(function () use ($inputs) {
                $filtered_inputs = $inputs->filter(function ($input, $key) {
                    return $input->u_id == $this->id;
                });
                $nums = ['m' => 0, 'j' => 0, 'b' => 0, 'y' => 0];
                foreach ($filtered_inputs as $input) {
                    $nums[$input->input_type] = $nums[$input->input_type] + $input->num;
                }
                $html = '';
                foreach ($nums as $key => $num) {
                    $html .= "<span>" . trans('front::lang.input_type.' . $key . '') . ":$num</span>&nbsp;&nbsp;&nbsp;";
                }
                return $html;
            });

            $grid->column('per', '提成比例')->display(function () use ($p) {
                $p_pers = ['m' => $p->per, 'j' => $p->per, 'b' => $p->per, 'y' => $p->per,];
                $pers = MenberPer::where('user_id', '=', \Front::user()->user_id)
                    ->where('menber_id', $this->id)
                    ->where('p_id', $p->id)
                    ->pluck('per', 'type')->toArray();
                $res_pers = array_merge($p_pers, $pers);
                $html = '';
                foreach ($res_pers as $key => $res_per) {
                    $html .= "<span>" . trans('front::lang.input_type.' . $key . '') . ":$res_per%</span>&nbsp;&nbsp;&nbsp;";
                }
                return $html;
            });

            $grid->column('should_shou_money', '应收金额')->display(function () use ($inputs) {
                $filtered_inputs = $inputs->filter(function ($input, $key) {
                    return $input->u_id == $this->id;
                });
                $should_shou_money = 0;
                foreach ($filtered_inputs as $input) {
                    $should_shou_money = $should_shou_money + $input['p_amount'];
                }
                return $should_shou_money;
            });
            $grid->column('fact_shou_money', '实收金额')->display(function () use ($inputs) {
                $filtered_inputs = $inputs->filter(function ($input, $key) {
                    return $input->u_id == $this->id;
                });
                $money_paid = 0;
                foreach ($filtered_inputs as $input) {
                    $money_paid = $money_paid + $input['money_paid'];
                }
                return $money_paid;
            });
            $grid->column('piao_money', '开票金额')->display(function () use ($inputs) {
                $filtered_inputs = $inputs->filter(function ($input, $key) {
                    return $input->u_id == $this->id;
                });
                $piao_money = 0;
                foreach ($filtered_inputs as $input) {
                    $piao_money = $piao_money + $input['piao_money'];
                }
                return $piao_money;
            });
            $grid->column('kou_money', '坐扣')->display(function () use ($inputs) {
                $filtered_inputs = $inputs->filter(function ($input, $key) {
                    return $input->u_id == $this->id;
                });
                $money_kou = 0;
                foreach ($filtered_inputs as $input) {
                    $money_kou = $money_kou + $input['money_kou'];
                }
                return $money_kou;
            });
            $grid->column('not_shou_money', '未收金额')->display(function () use ($inputs) {
                $filtered_inputs = $inputs->filter(function ($input, $key) {
                    return $input->u_id == $this->id;
                });
                $money_weishou = 0;
                foreach ($filtered_inputs as $input) {
                    $money_weishou = $money_weishou + ($input['p_amount'] - $input['money_paid'] - $input['money_kou']);
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
            $grid->column('jishuan_money', '应结算金额')->display(function () use ($inputs, $p,$target) {
                $menber_id = $this->id;
                return Cache::remember('should_ti_money'.$target->id.'.' . $menber_id, 1, function () use ($inputs, $p, $menber_id) {
                    $p_pers = ['m' => $p->per, 'j' => $p->per, 'b' => $p->per, 'y' => $p->per,];
                    $pers = MenberPer::where('user_id', '=', \Front::user()->user_id)
                        ->where('menber_id', $menber_id)
                        ->where('p_id', $p->id)
                        ->pluck('per', 'type')->toArray();
                    $res_pers = array_merge($p_pers, $pers);
                    $filtered_inputs = $inputs->filter(function ($input, $key) {
                        return $input->u_id == $this->id && $input->input_status == 3;
                    });
                    $should_ti_money = 0;
                    foreach ($filtered_inputs as $input) {
                        $should_ti_money = $should_ti_money + ($input['p_amount'] * $res_pers[$input['input_type']] / 100);
                    }
                    return $should_ti_money;
                });
            });

            $grid->column('not_jishuan_money', '未结算金额')->display(function () use ($inputs, $p, $target) {
                $menber_id = $this->id;
                $should_ti_money = Cache::get('should_ti_money'.$target->id.'.' . $menber_id);
                $last_ucheckout = Cache::remember('last_ucheckout'.$target->id.'.' . $menber_id, 1, function () use ($inputs, $p, $target, $menber_id) {
                    return UCheckout::where('user_id', '=', \Front::user()->user_id)
                        ->where('u_id', $menber_id)
                        ->where('t_id', $target->id)
                        ->latest()
                        ->first();
                });
                if ($last_ucheckout) {
                    return $should_ti_money - $last_ucheckout->moneyed;
                } else {
                    return $should_ti_money;
                }
            });

            $grid->column('j_status', '发放状态')->display(function () use ($inputs, $p, $target) {
                $menber_id = $this->id;
                $should_ti_money = Cache::get('should_ti_money'.$target->id.'.' . $menber_id);
                $last_ucheckout = Cache::get('last_ucheckout'.$target->id.'.' . $menber_id);

                if ($last_ucheckout) {
                    if ($should_ti_money == $last_ucheckout->moneyed) {
                        return trans('front::lang.j_status.1');
                    } else {
                        return trans('front::lang.j_status.2');
                    }
                } else {
                    return trans('front::lang.j_status.0');
                }

            });

            //grid actions
            $grid->actions(function ($actions) use ($target) {
                $actions->disableDelete();
                $actions->disableEdit();
                $should_ti_money = Cache::get('should_ti_money'.$target->getKey().'.' . $actions->getKey());
                $last_ucheckout = Cache::get('last_ucheckout'.$target->getKey().'.' . $actions->getKey());
                if ($last_ucheckout) {
                    if ($should_ti_money == $last_ucheckout->moneyed) {
                        $j_status = 1;
                    } else {
                        $j_status = 2;
                    }
                } else {
                    $j_status = 0;
                }
                $actions->append(new JisuanAction($actions->getKey(), $target->getKey(),$j_status));
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
            $grid->filter(function ($filter) {

                $filter->disableIdFilter();

                $filter->like('name', '姓名');

                $filter->is('d_id', '所属部门')->select(Department::selectOptionsForNoroot());

            });
        });


    }

    private function get_menber_not_jie_money($t_id, $u_id)
    {
        $target = Target::find($t_id);
        $inputs = $this->get_inputs_by_target_model($target);

        $p = $target->periodical;

        $last_ucheckout = Cache::remember('last_ucheckout'.$t_id.'.' . $u_id, 1, function () use ($inputs, $p, $t_id, $u_id) {
            return UCheckout::where('user_id', '=', \Front::user()->user_id)
                ->where('u_id', $u_id)
                ->where('t_id', $t_id)
                ->latest()
                ->first();
        });

        $should_ti_money = Cache::remember('should_ti_money'.$t_id.'.' . $u_id, 1, function () use ($inputs, $p, $u_id) {
            $p_pers = ['m' => $p->per, 'j' => $p->per, 'b' => $p->per, 'y' => $p->per,];
            $pers = MenberPer::where('user_id', '=', \Front::user()->user_id)
                ->where('menber_id', $u_id)
                ->where('p_id', $p->id)
                ->pluck('per', 'type')->toArray();
            $res_pers = array_merge($p_pers, $pers);
            $filtered_inputs = $inputs->filter(function ($input, $key) use ($u_id) {
                return $input->u_id == $u_id && $input->input_status == 3;
            });
            $should_ti_money = 0;
            foreach ($filtered_inputs as $input) {
                $should_ti_money = $should_ti_money + ($input['p_amount'] * $res_pers[$input['input_type']] / 100);
            }
            return $should_ti_money;
        });
        if ($last_ucheckout) {
            return $should_ti_money - $last_ucheckout->moneyed;
        } else {
            return $should_ti_money;
        }
    }


    private function get_inputs_by_target_model($target)
    {
        return Input::where('user_id', '=', \Front::user()->user_id)
            ->where('p_id', $target->p_id)
            ->where('created_at', '>=', $target->s_time)
            ->where('created_at', '<=', $target->e_time)
            ->get();
    }

    public function getDetail($t_id, $u_id)
    {
        $u_checkouts = UCheckout::where('t_id', $t_id)
            ->where('u_id', $u_id)
            ->get();
        if ($u_checkouts) {

            foreach ($u_checkouts as $key => $u_checkout) {
                $u_checkouts[$key]['key'] = "第" . ($key + 1) . "次发放";
                $u_checkouts[$key]['fa_time'] = \Carbon::parse($u_checkout['fa_time'])->format('Y-m-d');
            }
            return response()->json([
                'status' => true,
                'jisuans' => $u_checkouts,
                'not_jie_money' => $this->get_menber_not_jie_money($t_id, $u_id),
            ]);
        }
    }

    public function setDetail($t_id, $u_id, Request $request)
    {
        Cache::forget('should_ti_money'.$t_id.'');
        Cache::forget('last_ucheckout'.$t_id.'');

        $fafangmoney_key = 'fafangmoney' . $u_id;
        $fafangtype_key = 'fafangtype' . $u_id;
        $fa_time_key = 'fa_time' . $u_id;

        $fafangmoney = $request->{$fafangmoney_key};
        $fafangtype = $request->{$fafangtype_key};
        $fa_time = $request->{$fa_time_key};


        $target = Target::find($t_id);
        $p = $target->periodical;
        $menber = Menber::find($u_id);

        \DB::transaction(function () use ($fafangmoney, $fafangtype, $fa_time,$target, $menber, $p) {

            $last_u_checkout = UCheckout::where('t_id', $target->id)
                ->where('u_id', $target->id)
                ->latest()
                ->first();

            $u_checkout = new UCheckout;
            $u_checkout->user_id = $menber->user_id;
            $u_checkout->d_id = $menber->d_id;
            $u_checkout->p_id = $p->id;
            $u_checkout->u_id = $menber->id;
            $u_checkout->t_id = $target->id;
            $u_checkout->fafang_type = $fafangtype;
            $u_checkout->money = $fafangmoney;
            $u_checkout->fa_time = $fa_time;
            if ($last_u_checkout) {
                $u_checkout->moneyed = $last_u_checkout->moneyed + $fafangmoney;
            } else {
                $u_checkout->moneyed = $fafangmoney;
            }

            $u_checkout->save();
        });
        $info = new MessageBag([
            'title'   => '发放成功',
            'message' => '',
        ]);
        return back()->with(compact('info'));
    }

    public function update($t_id,$u_id,Request $request)
    {
        $edit_field = $request->name;
        if ($edit_field == 'fafang_type') {
            $this->validate($request,
                ['value' =>'bail|required|max:100'],
                [
                    'value.required' => '请输入发放方式',
                    'value.max' => '名称太长',
                ]
            );
        }
        if ($edit_field == 'fa_time') {
            $this->validate($request,
                ['value' =>'bail|required|date'],
                [
                    'value.required' => '请输入时间',
                    'value.date' => '请按YYYY-MM-DD的格式输入时间',
                ]
            );
        }

        $liushui_log = UCheckout::find($request->pk);
        $liushui_log->{$edit_field} = $request->value;
        $liushui_log->save();
    }
}
