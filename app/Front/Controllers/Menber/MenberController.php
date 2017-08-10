<?php

namespace App\Front\Controllers\Menber;

use App\Front\Controllers\ModelForm;
use App\Front\Extensions\MenberDel;
use App\Models\Department;
use App\Models\Menber;
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
        return \Front::content(function (Content $content) {
            $content->header('发行人');
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
        return \Front::content(function (Content $content) use ($id) {
            $content->header('发行人');
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
        return \Front::content(function (Content $content) {
            $content->header('发行人');
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
        return \Front::grid(Menber::class, function (Grid $grid) {
            $grid->model()
                ->where('user_id', '=', \Front::user()->user_id);

            $grid->name('姓名');

            $grid->department()->name('部门')->display(function () {
                if ($this->department['parent_id'] > 0) {
                    $parent_name = Department::where('id',$this->department['parent_id'] )->value('name');
                    return $this->department['name'] . '(' . $parent_name . ')';
                }
                return $this->department['name'];
            })->label();
            $grid->column('qrcode','二维码')->display(function () {
                return  '<img src="data:image/png;base64,'
                .base64_encode(
                    QrCode::format("png")
                        //->merge(asset('images/logo/logo'.\Front::user()->id.'.png'), .28,true)
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

                $filter->is('d_id', '所属部门')->select(Department::selectOptionsForNoroot());

            });

            $grid->actions(function ($actions) {
                $actions->disableDelete();
                //自定义删除
                $actions->append(new MenberDel($actions->getKey()));
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
        return \Front::form(Menber::class, function (Form $form) {

            $form->text('name', '姓名')->rules('required');
            $select = Department::selectOptionsForNoroot();
            $form->select('d_id','部门')->options($select);

            $form->display('created_at', trans('front::lang.created_at'));
            $form->display('updated_at', trans('front::lang.updated_at'));
            $form->hidden('user_id')->default(\Front::user()->user_id);

        });
    }
}
