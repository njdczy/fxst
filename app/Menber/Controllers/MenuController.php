<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/14
 * Time: 22:02
 */

namespace App\Menber\Controllers;

use App\Menber\Auth\Database\Menu;
use App\Menber\Auth\Database\Role;
use App\Menber\Facades\Menber;
use App\Menber\Form;
use App\Menber\Layout\Column;
use App\Menber\Layout\Content;
use App\Menber\Layout\Row;
use App\Menber\Tree;
use App\Menber\Widgets\Box;
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

        return Menber::content(function (Content $content) {
            $content->header(trans('menber::lang.menu'));
            $content->description(trans('menber::lang.list'));

            $content->row(function (Row $row) {
                $row->column(6, $this->treeView()->render());

                $row->column(6, function (Column $column) {
                    $form = new \App\Menber\Widgets\Form();
                    $form->action(menber_url('menu'));

                    $form->select('parent_id', trans('menber::lang.parent_id'))->options(Menu::selectOptions());
                    $form->text('title', trans('menber::lang.title'))->rules('required');
                    $form->icon('icon', trans('menber::lang.icon'))->default('fa-bars')->rules('required')->help($this->iconHelp());
                    $form->text('uri', trans('menber::lang.uri'));

                    $column->append((new Box(trans('menber::lang.new'), $form))->style('success'));
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
            '\App\Menber\Controllers\MenuController@edit', ['id' => $id]
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
                    $uri = menber_url($branch['uri']);

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
        return Menber::content(function (Content $content) use ($id) {
            $content->header(trans('menber::lang.menu'));
            $content->description(trans('menber::lang.edit'));

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

            $form->select('parent_id', trans('menber::lang.parent_id'))->options(Menu::selectOptions());
            $form->text('title', trans('menber::lang.title'))->rules('required');
            $form->icon('icon', trans('menber::lang.icon'))->default('fa-bars')->rules('required')->help($this->iconHelp());
            $form->text('uri', trans('menber::lang.uri'));

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