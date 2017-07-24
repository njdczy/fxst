<?php

namespace App\Front\Controllers;

use App\Zhenggg\Auth\Database\Administrator;
use App\Zhenggg\Auth\Database\Permission;
use App\Zhenggg\Auth\Database\Role;
use App\Zhenggg\Facades\Front;
use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Content;
use Illuminate\Routing\Controller;

use QrCode;

class MenberController extends Controller
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
            $grid->model()
                ->where('user_id', '=', Front::user()->user_id)
                ->orWhere('id', '=', Front::user()->user_id);
            $grid->username(trans('front::lang.username'));
            $grid->name(trans('front::lang.name'));
            $grid->roles(trans('front::lang.roles'))->pluck('name')->label();
            $grid->column('qrcode','二维码')->display(function () {
                return  '<img src="data:image/png;base64,'
                .base64_encode(
                    QrCode::format("png")
                        //->merge(asset('images/logo/logo'.Front::user()->id.'.png'), .28,true)
                        ->errorCorrection('H')
                        ->size(140)
                        ->generate(url("/form/".$this->id))
                )
                .'"/>';
            });
            $grid->money('余额');
            $grid->created_at(trans('front::lang.created_at'));
            $grid->updated_at(trans('front::lang.updated_at'));

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if ($actions->getKey() == 1) {
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
            $form->text('username', trans('front::lang.username'))->rules('required');
            $form->text('name', trans('front::lang.name'))->rules('required');
            $form->image('avatar', trans('front::lang.avatar'));
            $form->password('password', trans('front::lang.password'))->rules('required|confirmed');
            $form->password('password_confirmation', trans('front::lang.password_confirmation'))->rules('required')
                ->default(function ($form) {
                    return $form->model()->password;
                });

            $form->ignore(['password_confirmation']);

            $form->multipleSelect('roles', trans('front::lang.roles'))
                ->options(Role::where('user_id','=',Front::user()->user_id)->get()->pluck('name', 'id'));
            $form->multipleSelect('permissions', trans('front::lang.permissions'))
                ->options(Permission::where('user_id','=',Front::user()->user_id)->get()->pluck('name', 'id'));

            $form->display('created_at', trans('front::lang.created_at'));
            $form->display('updated_at', trans('front::lang.updated_at'));
            $form->hidden('user_id')->default(Front::user()->user_id);
            $form->saving(function (Form $form) {
                if ($form->password && $form->model()->password != $form->password) {
                        $form->password = bcrypt($form->password);
                }
            });
        });
    }
}
