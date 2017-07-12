<?php

namespace App\Front\Controllers;

use App\Zhenggg\Auth\Database\Menu;
use App\Zhenggg\Auth\Database\Permission;
use App\Zhenggg\Auth\Database\Role;
use App\Zhenggg\Facades\Front;
use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Column;
use App\Zhenggg\Layout\Content;
use App\Zhenggg\Layout\Row;
use App\Zhenggg\Tree;
use App\Zhenggg\Widgets\Box;
use App\Zhenggg\Widgets\Form as WidgetsFrom;
use Illuminate\Routing\Controller;

class PermissionController extends Controller
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
            $content->header(trans('front::lang.permissions'));
            $content->description(trans('front::lang.list'));

            $content->row(function (Row $row) {
                $row->column(10, $this->treeView()->render());

//                $row->column(6, function (Column $column) {
//                    $form = new WidgetsFrom();
//                    $form->action(front_url('auth/menu'));
//
//                    $form->select('parent_id', trans('front::lang.parent_id'))->options(Menu::selectOptions());
//                    $form->text('title', trans('front::lang.title'))->rules('required');
//                    $form->icon('icon', trans('front::lang.icon'))->default('fa-bars')->rules('required');
//                    $form->text('uri', trans('front::lang.uri'));
//                    $form->multipleSelect('roles', trans('front::lang.roles'))->options(Role::all()->pluck('name', 'id'));
//
//                    $column->append((new Box(trans('front::lang.new'), $form))->style('success'));
//                });
            });
        });
    }

    /**
     * @return \App\Zhenggg\Tree
     */
    protected function treeView()
    {
        return Menu::tree(function (Tree $tree) {
            $tree->disableCreate();

            $tree->branch(function ($branch) {
                $payload = "<i class='fa {$branch['icon']}'></i>&nbsp;<strong>{$branch['title']}</strong>";


                return $payload;
            });
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
            $content->header(trans('front::lang.permissions'));
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
            $content->header(trans('front::lang.permissions'));
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
        return Front::grid(Permission::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->slug(trans('front::lang.slug'));
            $grid->name(trans('front::lang.name'));

            $grid->created_at(trans('front::lang.created_at'));
            $grid->updated_at(trans('front::lang.updated_at'));

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
        return Front::form(Permission::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->text('slug', trans('front::lang.slug'))->rules('required');
            $form->text('name', trans('front::lang.name'))->rules('required');

            $form->display('created_at', trans('front::lang.created_at'));
            $form->display('updated_at', trans('front::lang.updated_at'));
        });
    }
}
