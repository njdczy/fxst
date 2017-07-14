<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/13
 * Time: 17:41
 */

namespace App\Front\Controllers;

use App\Periodical;
use App\Target;
use App\Zhenggg\Facades\Front;
use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Content;
use Illuminate\Routing\Controller;

class TargetController extends Controller
{
    use ModelForm;

    public function index()
    {
        return Front::content(function (Content $content) {

            $content->header('总目标');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return Front::content(function (Content $content) use ($id) {

            $content->header('总目标');
            $content->description('修改');

            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return Front::content(function (Content $content) {

            $content->header('总目标');
            $content->description('新建');

            $content->body($this->form());
        });
    }


    protected function grid()
    {
        return Front::grid(Target::class, function (Grid $grid) {
            $grid->model()->where('user_id', '=', Front::user()->user_id);
            $grid->p_id("刊物")->display(function () {
                return Periodical::where('id',$this->p_id)->value('name');
            });
            $grid->column("time", "时间段")->display(function () {
                return $this->s_time . ' ' . $this->e_time;
            });
            $grid->num('目标份数');
        });
    }


    protected function form()
    {
        return Front::form(Target::class, function (Form $form) {
            $form->select('p_id', '刊物')->options(
                Periodical::where('user_id', '=', Front::user()->user_id)
                    ->pluck('name', 'id')
            );
            $form->dateRange('s_time', 'e_time', '目标时间段');
            $form->number('num','份数');
            $form->hidden('user_id')->default(Front::user()->user_id);
        });
    }
}