<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/26
 * Time: 17:54
 */

namespace App\Front\Controllers\Base;

use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use App\Zhenggg\Facades\Admin;
use App\Zhenggg\Layout\Content;
use App\Zhenggg\Controllers\ModelForm;

use Illuminate\Routing\Controller;

class OfficeController extends Controller
{
    use ModelForm;

    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    protected function grid()
    {
        return Admin::grid(YourModel::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->created_at();
            $grid->updated_at();
        });
    }

    protected function form()
    {
        return Admin::form(YourModel::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}