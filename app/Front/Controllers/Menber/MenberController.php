<?php

namespace App\Front\Controllers\Menber;

use App\Front\Controllers\ModelForm;
use App\Models\Department;
use App\Models\Menber;
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
        return Menber::grid(function (Grid $grid) {
            $grid->model()
                ->where('user_id', '=', Front::user()->user_id)
                ->orWhere('id', '=', Front::user()->user_id);

            $grid->name('姓名');

            $grid->department()->name('部门')->label();
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

            $grid->filter(function($filter){

                $filter->disableIdFilter();

                $filter->like('name', '姓名');

                //$filter->is('d_id', '所属部门')->select(Department::selectOptions());

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
        return Menber::form(function (Form $form) {

            $form->text('name', '姓名')->rules('required');

            $form->select('d_id','部门')->options()->options(Department::selectOptions());

            $form->display('created_at', trans('front::lang.created_at'));
            $form->display('updated_at', trans('front::lang.updated_at'));
            $form->hidden('user_id')->default(Front::user()->user_id);

        });
    }
}
