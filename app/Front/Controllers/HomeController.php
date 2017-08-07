<?php

namespace App\Front\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Input;
use App\Models\Periodical;
use App\Zhenggg\Facades\Front;
use App\Zhenggg\Layout\Column;
use App\Zhenggg\Layout\Content;
use App\Zhenggg\Layout\Row;
use App\Zhenggg\Widgets\Box;

use App\Zhenggg\Widgets\Chart\Line;

use App\Zhenggg\Widgets\InfoBox;

use Carbon\Carbon;

class HomeController extends Controller
{
    public $dt;
    public $month_start;
    public $month_end;

    public function __construct()
    {
        $this->dt = Carbon::now();
        $this->month_start = $this->dt->startOfMonth()->toDateTimeString();
        $this->month_end = $this->dt->endOfMonth()->toDateTimeString();

        $this->year_start = $this->dt->startOfYear()->toDateTimeString();
        $this->year_end = $this->dt->endOfYear()->toDateTimeString();
    }

    public function index()
    {
        return Front::content(function (Content $content) {

            $content->header('发行管理系统');
            $content->description('发行管理系统');

            $content->row(function ($row) {

                $day_start = Carbon::today()->toDateTimeString();
                $day_end = Carbon::tomorrow()->toDateTimeString();
                $day_datetime = ['created_at' => ['start' => $day_start, 'end' => $day_end]];
                $day_order_url = '/front/finance/input?' . http_build_query($day_datetime);

                $day_input_num = Input::where('user_id', Front::user()->user_id)
                    ->whereBetween('created_at', [$day_start, $day_end])
                    ->sum('num');
                $row->column(3, new InfoBox('今日订单份数', 'shopping-cart', 'aqua', $day_order_url, $day_input_num));

                $row->column(1,'');

                    $month_datetime = ['created_at' => ['start' => $this->month_start, 'end' => $this->month_end]];
                $month_order_url = '/front/finance/input?' . http_build_query($month_datetime);

                $month_input_num = Input::where('user_id', Front::user()->user_id)
                    ->whereBetween('created_at', [$this->month_start, $this->month_end])
                    ->sum('num');
                $row->column(3, new InfoBox('今月订单份数', 'shopping-cart', 'green', $month_order_url, $month_input_num));

                $row->column(1,'');
                
                $year_datetime = ['created_at' => ['start' => $this->year_start, 'end' => $this->year_end]];
                $year_order_url = '/front/finance/input?' . http_build_query($year_datetime);

                $year_input_num = Input::where('user_id', Front::user()->user_id)
                    ->whereBetween('created_at', [$this->year_start, $this->year_end])
                    ->sum('num');
                $row->column(3, new InfoBox('今年订单份数', 'shopping-cart', 'yellow', $year_order_url, $year_input_num));


            });
            $p_ids = Periodical::all()->pluck('name', 'id');
            foreach ($p_ids as $p_id => $p_name) {
                $content->row(function (Row $row) use ($p_id, $p_name) {
                    $row->column(1, '');
                    $row->column(10, function (Column $column) use ($p_id, $p_name) {

                        $data = $this->getSellerQuData($p_id, $this->month_start, $this->month_end);

                        $month_day_num = $this->dt->diffInDays($this->dt->copy()->addMonth());

                        for ($i = 1; $i <= $month_day_num; $i++) {
                            $month_day_array[] = sprintf("%02d", $i);
                        }
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

                        $line = new Line($month_day_array,
                            [
                                ['', $month_money_array, 'rgba(75,192,192,1)'],
                            ]
                        );
                        $column->append((new Box($p_name . '——' . $this->dt->month . '月订单统计(份)', $line)));
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
    private function getSellerQuData($p_id, $start, $end)
    {
        //把数据添加时间按格式化时间分组求和,求和分两种,一种是直接求和,一种是满足case when条件的数据求和
        $query = \DB::table('inputs as i')
            ->select(\DB::raw("FROM_UNIXTIME(unix_timestamp(created_at),'%d') as dates,sum(case when i.input_status = 1 then i.p_amount end) as money"))
            ->groupBy(\DB::raw("dates"));

        if (!empty($p_id)) {
            $query->whereRaw('i.p_id = ?', $p_id);
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
