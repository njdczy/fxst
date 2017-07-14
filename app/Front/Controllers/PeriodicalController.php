<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/13
 * Time: 14:26
 */

namespace App\Front\Controllers;

use App\Periodical;
use App\Zhenggg\Facades\Front;
use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Content;
use Illuminate\Routing\Controller;

class PeriodicalController extends Controller
{
    use ModelForm;

    public function index()
    {
        return Front::content(function (Content $content) {

            $content->header('刊物');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return Front::content(function (Content $content) use ($id) {

            $content->header('刊物');
            $content->description('修改');

            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return Front::content(function (Content $content) {

            $content->header('刊物');
            $content->description('新建');

            $content->body($this->form());
        });
    }


    protected function grid()
    {
        return Front::grid(Periodical::class, function (Grid $grid) {
            $grid->model()->where('user_id', '=', Front::user()->user_id);
            $grid->name("刊物名称");

        });
    }


    protected function form()
    {
        return Front::form(Periodical::class, function (Form $form) {
            $form->text('name','刊物名称');

            $form->hidden('user_id')->default(Front::user()->user_id);

        });
    }

    public function destroy($id)
    {
        if ($this->form()->destroy($id)) {
            if (Periodical::where('id',$id)->exists()) {
                return response()->json([
                    'status'  => false,
                    'message' => '刊物下有目标，不能删除',
                ]);
            }
            return response()->json([
                'status'  => true,
                'message' => trans('front::lang.delete_succeeded'),
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => trans('front::lang.delete_failed'),
            ]);
        }
    }
}