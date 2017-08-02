<?php

namespace App\Zhenggg\Controllers;

use App\Zhenggg\Auth\Database\Administrator;
use App\Zhenggg\Auth\Database\Menu;
use App\Zhenggg\Auth\Database\Permission;
use App\Zhenggg\Auth\Database\Role;
use App\Zhenggg\Facades\Front;
use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
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
            $content->header(trans('front::lang.administrator'));
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
            $content->header(trans('front::lang.administrator'));
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
            $content->header(trans('front::lang.administrator'));
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
        return Administrator::grid(function (Grid $grid) {
            $grid->model()->where('user_id', '=', Front::user()->user_id);
            $grid->admin_account(trans('front::lang.admin_account'));
            $grid->admin_name(trans('front::lang.admin_name'));
            $grid->roles(trans('front::lang.admin_roles'))->pluck('name')->label();
            $grid->created_at(trans('front::lang.created_at'));
            $grid->updated_at(trans('front::lang.updated_at'));

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if ($actions->row->roles && $actions->row->roles[0]['slug'] == 'main_account') {
                    $actions->disableDelete();
                }
            });

            $grid->tools(function (Grid\Tools $tools) {
                $tools->batch(function (Grid\Tools\BatchActions $actions) {
                    $actions->disableDelete();
                });
            });

            $grid->disableExport();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {

        return Administrator::form(function (Form $form) {


            $form->text('admin_account', trans('front::lang.admin_account'))->rules('required');
            $form->text('admin_name', trans('front::lang.admin_name'))->rules('required');
            $form->image('avatar', trans('front::lang.avatar'));
            $form->password('password', trans('front::lang.password'))->rules('required|confirmed');
            $form->password('password_confirmation', trans('front::lang.password_confirmation'))->rules('required')
                ->default(function ($form) {
                    return $form->model()->password;
                });

            $form->ignore(['password_confirmation']);

            $form->select('roles', '角色')->options(Role::all()->pluck('name', 'id'));

//            $form->multipleSelect('permissions', trans('front::lang.permissions'))
//                ->options(Permission::all()->pluck('name', 'id'));
            //$form->radio('permissions', trans('front::lang.permissions'))->default('m');

            $form->pSelect('permissions', trans('front::lang.permissions'))
                ->options(Permission::orderBy('parent_id', 'asc')->get()->pluck('name', 'id'));

            $form->display('created_at', trans('front::lang.created_at'));
            $form->display('updated_at', trans('front::lang.updated_at'));
            $form->hidden('user_id')->default(Front::user()->user_id);
            $form->html('<script>
            function check(){}
</script>');

            $form->saving(function (Form $form) {
                if ($form->password && $form->model()->password != $form->password) {
                    $form->password = bcrypt($form->password);
                }
            });
        });
    }

    public function pselect(Request $req)
    {
        $res = ['parent_id'=>'','children_id'=>[]];
        $val = $req->input('val');
        $parent_id = Permission::where('id',$val)->value('parent_id');
        if ($parent_id) {
            $res['parent_id'] = $parent_id;
        }
        $children = Permission::where('parent_id',$val)->get();
        if (!$children->isEmpty()) {

            foreach ($children as $key => $child) {
                $children_id[] = $child->id;
            }
            if ($children_id) {
                $res['children_id'] = $children_id;
            }
        }

        die(json_encode($res));


    }

}
