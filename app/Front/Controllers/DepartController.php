<?php

namespace App\Front\Controllers;

use App\Zhenggg\Auth\Database\Permission;
use App\Zhenggg\Auth\Database\Role;
use App\Zhenggg\Facades\Front;
use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Content;
use Illuminate\Routing\Controller;

class DepartController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Front::content(function (Content $content) {
            $content->header(trans('front::lang.roles'));
            $content->description(trans('front::lang.list'));
            $content->body($this->grid()->render());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     *
     * @return Content
     */
    public function edit($id)
    {
        return Front::content(function (Content $content) use ($id) {
            $content->header(trans('front::lang.roles'));
            $content->description(trans('front::lang.edit'));
            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Front::content(function (Content $content) {
            $content->header(trans('front::lang.roles'));
            $content->description(trans('front::lang.create'));
            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Front::grid(Role::class, function (Grid $grid) {
            $grid->model()->where('user_id', '=', Front::user()->user_id);
            $grid->slug(trans('front::lang.slug'));
            $grid->name(trans('front::lang.name'));
            $grid->menber_count('人数');


            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if ($actions->row->slug == 'main_account') {
                    $actions->disableDelete();
                }
            });

            $grid->tools(function (Grid\Tools $tools) {
                $tools->batch(function (Grid\Tools\BatchActions $actions) {
                    $actions->disableDelete();
                });
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        return Front::form(Role::class, function (Form $form) {
            $form->text('slug', trans('front::lang.slug'))->rules('required');
            $form->text('name', trans('front::lang.name'))->rules('required');
            $form->multipleSelect('permissions', trans('front::lang.permissions'))->options(
                Permission::where('parent_id',0)
                    ->pluck('name', 'id')
            );
            $form->hidden('user_id')->default(Front::user()->user_id);
        });
    }
}
