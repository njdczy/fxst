<?php

namespace App\Front\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Input;
use App\Zhenggg\Facades\Front;
use App\Zhenggg\Layout\Column;
use App\Zhenggg\Layout\Content;
use App\Zhenggg\Layout\Row;
use App\Zhenggg\Widgets\Box;
use App\Zhenggg\Widgets\Chart\Bar;
use App\Zhenggg\Widgets\Chart\Doughnut;
use App\Zhenggg\Widgets\Chart\Line;
use App\Zhenggg\Widgets\Chart\Pie;
use App\Zhenggg\Widgets\Chart\PolarArea;
use App\Zhenggg\Widgets\Chart\Radar;
use App\Zhenggg\Widgets\Collapse;
use App\Zhenggg\Widgets\InfoBox;
use App\Zhenggg\Widgets\Tab;
use App\Zhenggg\Widgets\Table;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        return Front::content(function (Content $content) {

            $content->header('发行管理系统');
            $content->description('发行管理系统');

            $content->row(function ($row) {
                $day_start = Carbon::today()->toDateTimeString();
                $day_end = Carbon::tomorrow()->toDateTimeString();
                $day_datetime = ['created_at'=>['start'=>$day_start,'end'=>$day_end]];
                $day_order_url = '/front/finance/input?'. http_build_query($day_datetime);

                $day_input_num = Input::where('user_id', Front::user()->user_id)
                    ->whereBetween('created_at', [$day_start,$day_end])
                    ->count();
                $row->column(3, new InfoBox('今日订单', 'shopping-cart', 'aqua', $day_order_url, $day_input_num));

                $month_start = Carbon::now()->startOfMonth()->toDateTimeString();
                $month_end = Carbon::now()->endOfMonth()->toDateTimeString();
                $month_datetime = ['created_at'=>['start'=>$month_start,'end'=>$month_end]];
                $month_order_url = '/front/finance/input?'. http_build_query($month_datetime);

                $month_input_num = Input::where('user_id', Front::user()->user_id)
                    ->whereBetween('created_at', [$month_start,$month_end])
                    ->count();
                $row->column(3, new InfoBox('今月订单', 'shopping-cart', 'green', $month_order_url, $month_input_num));



//                $data = $this->getSellerQuData('2017-08-01 00:00:00','2017-08-31 00:00:00');
//                dd($data);
            });

            $content->row(function (Row $row) {

//                $row->column(6, function (Column $column) {
//
//                    $tab = new Tab();
//
//                    $pie = new Pie([
//                        ['Stracke Ltd', 450], ['Halvorson PLC', 650], ['Dicki-Braun', 250], ['Russel-Blanda', 300],
//                        ['Emmerich-O\'Keefe', 400], ['Bauch Inc', 200], ['Leannon and Sons', 250], ['Gibson LLC', 250],
//                    ]);
//
//                    $tab->add('Pie', $pie);
//                    $tab->add('Table', new Table());
//                    $tab->add('Text', 'blablablabla....');
//
//                    $tab->dropDown([['Orders', '/admin/orders'], ['administrators', '/admin/administrators']]);
//                    $tab->title('Tabs');
//
//                    $column->append($tab);
//
//                    $collapse = new Collapse();
//
//                    $bar = new Bar(
//                        ["January", "February", "March", "April", "May", "June", "July"],
//                        [
//                            ['First', [40,56,67,23,10,45,78]],
//                            ['Second', [93,23,12,23,75,21,88]],
//                            ['Third', [33,82,34,56,87,12,56]],
//                            ['Forth', [34,25,67,12,48,91,16]],
//                        ]
//                    );
//                    $collapse->add('Bar', $bar);
//                    $collapse->add('Orders', new Table());
//                    $column->append($collapse);
//
//                    $doughnut = new Doughnut([
//                        ['Chrome', 700],
//                        ['IE', 500],
//                        ['FireFox', 400],
//                        ['Safari', 600],
//                        ['Opera', 300],
//                        ['Navigator', 100],
//                    ]);
//                    $column->append((new Box('Doughnut', $doughnut))->removable()->collapsable()->style('info'));
//                });

                $row->column(6, function (Column $column) {

//                    $column->append(new Box('Radar', new Radar()));
//
//                    $polarArea = new PolarArea([
//                        ['Red', 300],
//                        ['Blue', 450],
//                        ['Green', 700],
//                        ['Yellow', 280],
//                        ['Black', 425],
//                        ['Gray', 1000],
//                    ]);
//                    $column->append((new Box('Polar Area', $polarArea))->removable()->collapsable());
//
//                    $column->append((new Box('Line', new Line()))->removable()->collapsable()->style('danger'));
                });

            });
//
//            $headers = ['Id', 'Email', 'Name', 'Company', 'Last Login', 'Status'];
//            $rows = [
//                [1, 'labore21@yahoo.com', 'Ms. Clotilde Gibson', 'Goodwin-Watsica', '1997-08-13 13:59:21', 'open'],
//                [2, 'omnis.in@hotmail.com', 'Allie Kuhic', 'Murphy, Koepp and Morar', '1988-07-19 03:19:08', 'blocked'],
//                [3, 'quia65@hotmail.com', 'Prof. Drew Heller', 'Kihn LLC', '1978-06-19 11:12:57', 'blocked'],
//                [4, 'xet@yahoo.com', 'William Koss', 'Becker-Raynor', '1988-09-07 23:57:45', 'open'],
//                [5, 'ipsa.aut@gmail.com', 'Ms. Antonietta Kozey Jr.', 'Braun Ltd', '2013-10-16 10:00:01', 'open'],
//            ];
//
//            $content->row((new Box('Table', new Table($headers, $rows)))->style('info')->solid());
        });
    }

    /**
     * [getSellerQuData 获取商户结算数据 曲线]
     * @param  [string] $start [起始时间]2017-08
     * @param  [string] $end   [结束时间]
     * @return [type]        [description]
     */
    private function getSellerQuData($start,$end){

        //计算时间差值,以决定格式化时间格式
        $diff = strtotime($end)-strtotime($start);

        //分组条件 1天内按小时分组,否则按天/月分组
        //86400/1天 2678400/1月
        if($diff<86400&&$diff>0){
            $sort = '%H';
        }elseif($diff<2678400){
            $sort = '%Y-%m-%d';
        }else{
            $sort = '%Y-%m';
        }
        //把数据添加时间按格式化时间分组求和,求和分两种,一种是直接求和,一种是满足case when条件的数据求和
        $query = \DB::table('inputs as i')->select(\DB::raw("FROM_UNIXTIME(created_at,'{$sort}') as thedata,sum(case when i.input_status = 1 then i.p_amount end) as xiabi,sum(case when i.input_status = 0 then i.p_amount end) as online,sum(i.p_amount) as alls"))->groupBy(\DB::raw("FROM_UNIXTIME(created_at,'{$sort}')"));

        //条件筛选 某时间段内
        if( !empty($start) ){
            $query->whereRaw('i.created_at >= ?',strtotime($start));
        }
        if( !empty($end) ){
            $query->whereRaw('i.created_at <= ?',strtotime($end));
        }

        $data = $query->get();

        return $data;
    }
}
