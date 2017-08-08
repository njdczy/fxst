<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/26
 * Time: 17:54
 */

namespace App\Front\Controllers\Baoshe;

use App\Models\Baoshe;
use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Content;
use App\Zhenggg\Controllers\ModelForm;

use Illuminate\Routing\Controller;

class BaosheController extends Controller
{
    use ModelForm;

    public function index()
    {
        return \Front::content(function (Content $content) {

            $content->header('报社');
            $content->description('管理');

            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return \Front::content(function (Content $content) use ($id) {

            $content->header('报社');
            $content->description('管理');

            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return \Front::content(function (Content $content) {

            $content->header('报社');
            $content->description('管理');

            $content->body($this->form());
        });
    }

    protected function grid()
    {
        return \Front::grid(Baoshe::class, function (Grid $grid) {
            $grid->model()->where('user_id', '=', \Front::user()->user_id);
            $grid->column('');
            $grid->column('');
            $grid->name('报社名称');
            $grid->disableExport();
            $grid->disableFilter();
            $grid->disableRowSelector();
        });
    }

    protected function form()
    {
        return \Front::form(Baoshe::class, function (Form $form) {

            $form->hidden('user_id')->default(\Front::user()->user_id);
            $form->text('name','报社名称')->rules('required')->help('如：江苏经济报社');
        });
    }

    public function destroy($id)
    {
        if (!Baoshe::find($id)->periodical->isEmpty()) {
            return response()->json([
                'status'  => false,
                'message' => '报社下有刊物，不能删除',
            ]);
        }
        if ($this->form()->destroy($id)) {
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