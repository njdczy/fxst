<?php

namespace App\Zhenggg\Controllers;

use App\Zhenggg\Auth\Database\Permission;
use App\Zhenggg\Auth\Database\Role;
use App\Zhenggg\Facades\Front;
use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Content;
use Illuminate\Routing\Controller;

class RoleController extends Controller
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
            $grid->id('ID')->sortable();
            $grid->slug(trans('front::lang.slug'));
            $grid->name(trans('front::lang.name'));

            $grid->created_at(trans('front::lang.created_at'));
            $grid->updated_at(trans('front::lang.updated_at'));

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if ($actions->row->slug == 'administrator') {
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
            $form->display('id', 'ID');

            $form->text('slug', trans('front::lang.slug'))->rules('required');
            $form->text('name', trans('front::lang.name'))->rules('required');
            $form->multipleSelect('permissions', trans('front::lang.permissions'))->options(Permission::all()->pluck('name', 'id'));

            $form->display('created_at', trans('front::lang.created_at'));
            $form->display('updated_at', trans('front::lang.updated_at'));
        });
    }
}
