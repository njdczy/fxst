<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/21
 * Time: 23:26
 */

namespace App\Front\Controllers\Chart;


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
use Illuminate\Routing\Controller;

class UserChartController extends Controller
{
    public function index()
    {
        return \Front::content(function (Content $content) {


            $content->row(function (Row $row) {
                $row->column(2, function (Column $column) {});
                $row->column(8, function (Column $column) {


                    $pie = new Pie([
                        ['南京市', 450],
                        ['淮安市', 650],
                        ['南通市', 250],
                        ['苏州市', 300],
                        ['无锡市', 400],
                        ['常州市', 200],
                        ['泰州市', 250],
                        ['徐州市', 250],
                        ['宿迁市', 250],
                        ['连云港市', 250],
                        ['盐城市', 250],
                        ['镇江市', 250],
                        ['扬州市', 250],
                        ['其他', 10],
                    ]);

                    $column->append((new Box('客户地区分布', $pie)));
                });

            });

            $content->row(function (Row $row) {
                $row->column(2, function (Column $column) {});
                $row->column(8, function (Column $column) {


                    $doughnut = new Doughnut([
                        ['制造业', 700],
                        ['金融业', 500],
                        ['教育', 400],
                        ['批发和零售业', 600],
                        ['公共管理、社会保障和社会组织', 300],
                        ['文化、体育和娱乐业', 100],
                    ]);
                    $column->append((new Box('客户行业类型分布', $doughnut))->style('info'));
                });

            });

        });
    }
}