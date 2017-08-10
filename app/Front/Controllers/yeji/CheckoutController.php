<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/18
 * Time: 17:42
 */

namespace App\Front\Controllers\Yeji;

use App\Models\Department;
use App\Models\Menber;


use App\Zhenggg\Form;
use App\Zhenggg\Grid;

use App\Zhenggg\Layout\Content;
use App\Zhenggg\Controllers\ModelForm;
use Illuminate\Routing\Controller;

class CheckoutController extends  Controller
{
    use ModelForm;

    public function index()
    {
        return \Front::content(function (Content $content) {

            $content->header('业绩');
            $content->description('结算');

            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return \Front::content(function (Content $content) use ($id) {

            $content->header('业绩');
            $content->description('结算');

            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return \Front::content(function (Content $content) {

            $content->header('业绩');
            $content->description('结算');

            $content->body($this->form());
        });
    }

    protected function grid()
    {
        return \Front::grid(Menber::class, function (Grid $grid) {
            $grid->model()->where('user_id', '=', \Front::user()->user_id);
            $grid->name('人员');
            $grid->department()->name('部门')->display(function () {
                if ($this->department['parent_id'] > 0) {
                    $parent_name = Department::where('id',$this->department['parent_id'] )->value('name');
                    return $this->department['name'] . '(' . $parent_name . ')';
                }
                return $this->department['name'];
            })->label();
//            $grid->id("总有效销售额/已结算/未结算")->display(function(){
//                $checkout = UCheckout::where('u_id',$this->id)->first();
//                $h = '';
//                if ($checkout) {
//                    $h .= $checkout->all_money  . "/" . $checkout->j_money  . "/" . $checkout->no_money  . "" . "<br/>";
//                }
//                return $h;
//            });
            $grid->column('details','目标详情(确认并付完全款)')->display(function(){
               return "<a href='checkout/$this->id/details'>查看</a>";
            });
            $grid->actions(function ($actions) {
                $actions->disableDelete();
                $actions->disableEdit();
            });
            $grid->disableExport();
            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            });
            $grid->filter(function($filter){

                $filter->disableIdFilter();

                $filter->like('name', '姓名');

                $filter->is('d_id', '所属部门')->select(Department::selectOptionsForNoroot());

            });
        });
    }

    protected function form()
    {
        return \Front::form(Menber::class, function (Form $form) {

            $form->display('name', '名称');
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}