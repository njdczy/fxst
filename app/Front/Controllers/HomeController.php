<?php

namespace App\Front\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Input;
use App\Models\Periodical;
use App\Zhenggg\Layout\Column;
use App\Zhenggg\Layout\Content;
use App\Zhenggg\Layout\Row;
use App\Zhenggg\Widgets\Box;

use App\Zhenggg\Widgets\Chart\Line;

use App\Zhenggg\Widgets\InfoBox;

use Carbon\Carbon;

class HomeController extends Controller
{
    public $d_id;
    public $department;
    public $dt;
    public $month_start;
    public $month_end;

    public function __construct()
    {
        $this->d_id = request('d_id', 0);
        $this->department = Department::where('id', $this->d_id)
            ->first();
        $this->dt = Carbon::now();
        $this->month_start = $this->dt->startOfMonth()->toDateTimeString();
        $this->month_end = $this->dt->endOfMonth()->toDateTimeString();

        $this->year_start = $this->dt->startOfYear()->toDateTimeString();
        $this->year_end = $this->dt->endOfYear()->toDateTimeString();
    }

    public function index()
    {

        return \Front::content(function (Content $content) {

            $content->header('发行管理系统');
            $content->description('发行管理系统');
            $content->row(function ($row) {
                $row->column(4, '');
                $row->column(4, view('front::zhenggg.shaixuan', ['options' => Department::selectOptions(), 'value' => $this->d_id])->render());
            });
            $content->row(function ($row) {
                $row->column(12, '<hr/>');
            });
            $content->row(function ($row) {

                $day_start = Carbon::today()->toDateTimeString();
                $day_end = Carbon::tomorrow()->toDateTimeString();
                $day_query_data = ['created_at' => ['start' => $day_start, 'end' => $day_end]];
                if ($this->department) {
                    $day_query_data['d_id'] = $this->d_id;
                }
                $day_order_url = \Front::url('finance/input') . '?' . http_build_query($day_query_data);

                $day_input_num = Input::where('user_id', \Front::user()->user_id)
                    ->whereBetween('created_at', [$day_start, $day_end])
                    ->sum('num');
                if ($this->department) {
                    $day_input_department_num = Input::where('user_id', \Front::user()->user_id)
                        ->where('d_id', $this->d_id)
                        ->whereBetween('created_at', [$day_start, $day_end])
                        ->sum('num');
                }
                $info_box_name = $this->department ? '今日总订单份数 / ' . $this->department->name . '部门份数' : '今日总订单份数';
                $info_box_info = $this->department ? $day_input_num . '/ ' . $day_input_department_num : $day_input_num;
                $row->column(3, new InfoBox($info_box_name, 'shopping-cart', 'aqua', $day_order_url, $info_box_info));
                $row->column(1, '');


                $month_query_data = ['created_at' => ['start' => $this->month_start, 'end' => $this->month_end]];
                if ($this->department) {
                    $month_query_data['d_id'] = $this->d_id;
                }
                $month_order_url = \Front::url('finance/input') . '?' . http_build_query($month_query_data);

                $month_input_num = Input::where('user_id', \Front::user()->user_id)
                    ->whereBetween('created_at', [$this->month_start, $this->month_end])
                    ->sum('num');
                if ($this->department) {
                    $month_input_department_num = Input::where('user_id', \Front::user()->user_id)
                        ->where('d_id', $this->d_id)
                        ->whereBetween('created_at', [$this->month_start, $this->month_end])
                        ->sum('num');
                }
                $info_box_name = $this->department ? '今月总订单份数 / ' . $this->department->name . '部门份数' : '今月总订单份数';
                $info_box_info = $this->department ? $month_input_num . '/ ' . $month_input_department_num : $month_input_num;
                $row->column(3, new InfoBox($info_box_name, 'shopping-cart', 'green', $month_order_url, $info_box_info));
                $row->column(1, '');


                $year_query_data = ['created_at' => ['start' => $this->year_start, 'end' => $this->year_end]];
                if ($this->department) {
                    $year_query_data['d_id'] = $this->d_id;
                }
                $year_order_url = \Front::url('finance/input') . '/?' . http_build_query($year_query_data);

                $year_input_num = Input::where('user_id', \Front::user()->user_id)
                    ->whereBetween('created_at', [$this->year_start, $this->year_end])
                    ->sum('num');

                if ($this->department) {
                    $year_input_department_num = Input::where('user_id', \Front::user()->user_id)
                        ->where('d_id', $this->d_id)
                        ->whereBetween('created_at', [$this->year_start, $this->year_end])
                        ->sum('num');
                }
                $info_box_name = $this->department ? '今年总订单份数 / ' . $this->department->name . '部门份数' : '今年总订单份数';
                $info_box_info = $this->department ? $year_input_num . '/ ' . $year_input_department_num : $year_input_num;

                $row->column(3, new InfoBox($info_box_name, 'shopping-cart', 'yellow', $year_order_url, $info_box_info));


            });
            $p_ids = Periodical::all()->pluck('name', 'id');
            foreach ($p_ids as $p_id => $p_name) {
                $content->row(function (Row $row) use ($p_id, $p_name) {
                    $row->column(11, function (Column $column) use ($p_id, $p_name) {
                        $month_day_num = $this->dt->diffInDays($this->dt->copy()->addMonth());
                        for ($i = 1; $i <= $month_day_num; $i++) {
                            $month_day_array[] = sprintf("%02d", $i);
                        }

                        //all
                        $data = $this->getSellerQuData($p_id, 0, $this->month_start, $this->month_end);
                        $dates_array = [];
                        foreach ($data as $key => $value) {
                            $dates_array[$value->dates] = $value->money;
                        }
                        foreach ($month_day_array as $dayk => $day) {
                            $bool = array_key_exists($day, $dates_array);
                            if ($bool) {
                                $month_money_array[$dayk] = $dates_array[$day];
                            } else {
                                $month_money_array[$dayk] = 0;
                            }
                        }
                        $line_array = ['', $month_money_array, 'rgba(75,192,192,1)'];

                        //department
                        if ($this->d_id) {
                            $data = $this->getSellerQuData($p_id, $this->d_id, $this->month_start, $this->month_end);
                            $dates_array = [];
                            foreach ($data as $key => $value) {
                                $dates_array[$value->dates] = $value->money;
                            }
                            foreach ($month_day_array as $dayk => $day) {
                                $bool = array_key_exists($day, $dates_array);
                                if ($bool) {
                                    $month_money_array[$dayk] = $dates_array[$day];
                                } else {
                                    $month_money_array[$dayk] = 0;
                                }
                            }
                            $line_department = ['', $month_money_array, 'rgba(75,88,88,1)'];
                            $line_array = [$line_array, $line_department];
                        } else {
                            $line_array = [$line_array];
                        }

                        $line = new Line($month_day_array, $line_array);

                        $column->append((new Box($p_name . '——' . Carbon::now()->month . '月订单统计(份)', $line)));
                    });
                });
            }
        });
    }

    /**
     * [getSellerQuData 获取商户结算数据 曲线]
     * @param  [mix] $p_id p_id
     * @param  [string] $start [起始时间]2017-08
     * @param  [string] $end   [结束时间]
     * @return [type]        [description]
     */
    private function getSellerQuData($p_id, $d_id, $start, $end)
    {
        //把数据添加时间按格式化时间分组求和,求和分两种,一种是直接求和,一种是满足case when条件的数据求和
        $query = \DB::table('inputs as i')
            ->select(\DB::raw("FROM_UNIXTIME(unix_timestamp(created_at),'%d') as dates,sum(case when i.input_status = 1 then i.p_amount end) as money"))
            ->groupBy(\DB::raw("dates"));

        if (!empty($p_id)) {
            $query->whereRaw('i.p_id = ?', $p_id);
        }

        if ($d_id) {
            $query->whereRaw('i.d_id = ?', $d_id);
        }

        //条件筛选 某时间段内
        if (!empty($start)) {
            $query->whereRaw('i.created_at >= ?', $start);
        }
        if (!empty($end)) {
            $query->whereRaw('i.created_at <= ?', $end);
        }

        return $query->get()->toArray();

    }
}
