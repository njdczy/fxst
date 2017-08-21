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
use App\Models\Menber;



use App\Zhenggg\Grid;

use App\Zhenggg\Layout\Content;

use Illuminate\Routing\Controller;

class CheckoutController extends  Controller
{

    public function index()
    {
        return \Front::content(function (Content $content) {

            $content->header('业绩');
            $content->description('结算');

            $content->body($this->grid());
        });
    }

    protected function grid()
    {
        return \Front::grid(Menber::class, function (Grid $grid) {
            //grid model filters
            $grid->model()->where('user_id', '=', \Front::user()->user_id);

            //grid columns
            $grid->name('发行人');
            $grid->department()->name('部门')->display(function () {
                if ($this->department['parent_id'] > 0) {
                    $parent_name = Department::where('id',$this->department['parent_id'] )->value('name');
                    return $this->department['name'] . '(' . $parent_name . ')';
                }
                return $this->department['name'];
            })->label();

            $grid->column('num','数量');
            $grid->column('should_shou_money','应收金额');
            $grid->column('fact_shou_money','实收金额');
            $grid->column('piao_money','开票金额');
            $grid->column('kou_money','坐扣');
            $grid->column('not_shou_money','未收金额');
            $grid->column('last_money','最终金额');
            $grid->column('per','提成比例');
            $grid->column('jishuan_money','结算金额');
            $grid->column('not_jishuan_money','未结算金额');
            $grid->column('j_status','发放状态');

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