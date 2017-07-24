<?php
/**
 * Created by PhpStorm.
 * User: \App\Zhenggg\Facades\Frontistrator
 * Date: 2017/7/18
 * Time: 18:08
 */

namespace App\Front\Controllers;

use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Content;
use App\Zhenggg\Controllers\ModelForm;
use App\Periodical;
use App\Zhenggg\Facades\Front;
use Illuminate\Routing\Controller;

class AlldisperController extends Controller
{
    use ModelForm;

    public function index()
    {
        return Front::content(function (Content $content) {

            $content->header('设置');
            $content->description('总比例');

            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return Front::content(function (Content $content) use ($id) {

            $content->header('设置');
            $content->description('总比例');

            $content->body($this->form()->edit($id));
        });
    }

    protected function grid()
    {
        return Front::grid(Periodical::class, function (Grid $grid) {
            $grid->model()->where('user_id', '=', Front::user()->user_id);
            $grid->column('');
            $grid->name("刊物");
            $grid->per("比例（百分比）");
            $grid->disableCreation();
            $grid->disableExport();
            $grid->disableFilter();
            $grid->disableRowSelector();
            $grid->actions(function ($actions) {
                $actions->disableDelete();
            });
        });
    }

    protected function form()
    {
        return Front::form(Periodical::class, function (Form $form) {

            $form->display('name', '刊物');
            $form->number('per', '比例（百分比）')->rules('numeric|min:0|max:100');

        });
    }
}