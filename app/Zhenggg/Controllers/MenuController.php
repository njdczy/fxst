<?php

namespace App\Zhenggg\Controllers;

use App\Zhenggg\Auth\Database\Menu;
use App\Zhenggg\Auth\Database\Role;
use App\Zhenggg\Facades\Front;
use App\Zhenggg\Form;
use App\Zhenggg\Layout\Column;
use App\Zhenggg\Layout\Content;
use App\Zhenggg\Layout\Row;
use App\Zhenggg\Tree;
use App\Zhenggg\Widgets\Box;
use Illuminate\Routing\Controller;

class MenuController extends Controller
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
            $content->header(trans('front::lang.menu'));
            $content->description(trans('front::lang.list'));

            $content->row(function (Row $row) {
                $row->column(6, $this->treeView()->render());

                $row->column(6, function (Column $column) {
                    $form = new \App\Zhenggg\Widgets\Form();
                    $form->action(front_url('auth/menu'));

                    $form->select('parent_id', trans('front::lang.parent_id'))->options(Menu::selectOptions());
                    $form->text('title', trans('front::lang.title'))->rules('required');
                    $form->icon('icon', trans('front::lang.icon'))->default('fa-bars')->rules('required')->help($this->iconHelp());
                    $form->text('uri', trans('front::lang.uri'));
                    $form->multipleSelect('roles', trans('front::lang.roles'))->options(Role::all()->pluck('name', 'id'));

                    $column->append((new Box(trans('front::lang.new'), $form))->style('success'));
                });
            });
        });
    }

    /**
     * Redirect to edit page.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        return redirect()->action(
            '\App\Zhenggg\Controllers\MenuController@edit', ['id' => $id]
        );
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

                if (!isset($branch['children'])) {
                    $uri = front_url($branch['uri']);

                    $payload .= "&nbsp;&nbsp;&nbsp;<a href=\"$uri\" class=\"dd-nodrag\">$uri</a>";
                }

                return $payload;
            });
        });
    }

    /**
     * Edit interface.
     *
     * @param string $id
     *
     * @return Content
     */
    public function edit($id)
    {
        return Front::content(function (Content $content) use ($id) {
            $content->header(trans('front::lang.menu'));
            $content->description(trans('front::lang.edit'));

            $content->row($this->form()->edit($id));
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        return Menu::form(function (Form $form) {
            $form->display('id', 'ID');

            $form->select('parent_id', trans('front::lang.parent_id'))->options(Menu::selectOptions());
            $form->text('title', trans('front::lang.title'))->rules('required');
            $form->icon('icon', trans('front::lang.icon'))->default('fa-bars')->rules('required')->help($this->iconHelp());
            $form->text('uri', trans('front::lang.uri'));
            $form->multipleSelect('roles', trans('front::lang.roles'))->options(Role::all()->pluck('name', 'id'));

            $form->display('created_at', trans('front::lang.created_at'));
            $form->display('updated_at', trans('front::lang.updated_at'));
        });
    }

    /**
     * Help message for icon field.
     *
     * @return string
     */
    protected function iconHelp()
    {
        return 'For more icons please see <a href="http://fontawesome.io/icons/" target="_blank">http://fontawesome.io/icons/</a>';
    }
}
