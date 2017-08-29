<?php


namespace App\Front\Controllers\Base;

use App\Models\Type;
use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Content;
use App\Zhenggg\Controllers\ModelForm;

use Illuminate\Routing\Controller;

class HangyeController extends Controller
{
    use ModelForm;

    public function index()
    {
        return \Front::content(function (Content $content) {

            $content->header('行业名称');
            $content->description('管理');

            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return \Front::content(function (Content $content) use ($id) {

            $content->header('行业名称');
            $content->description('管理');

            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return \Front::content(function (Content $content) {

            $content->header('行业名称');
            $content->description('管理');

            $content->body($this->form());
        });
    }

    protected function grid()
    {
        return \Front::grid(Type::class, function (Grid $grid) {
            $grid->model()
                ->whereIn ('user_id', [\Front::user()->user_id,0])
                ->where('type', '=', 'hangye')
                ->orderBy('created_at', '=', 'desc');
            $grid->column('');
            $grid->column('');
            $grid->name('行业名称');
            $grid->disableExport();
            $grid->disableFilter();
            $grid->disableRowSelector();
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if ($actions->row->code != null) {
                    $actions->disableDelete();
                    $actions->disableEdit();
                }
            });
        });
    }

    protected function form()
    {
        return \Front::form(Type::class, function (Form $form) {

            $form->hidden('user_id')->default(\Front::user()->user_id);
            $form->hidden('type')->default('hangye');
            $form->text('name','行业名称')->rules('required');
        });
    }
}