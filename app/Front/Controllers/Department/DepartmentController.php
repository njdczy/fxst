<?php

namespace App\Front\Controllers\Department;

use App\Front\Controllers\ModelForm;

use App\Models\Department;
use App\Models\Menber;
use App\Zhenggg\Facades\Front;
use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Column;
use App\Zhenggg\Tree;
use App\Zhenggg\Layout\Content;
use App\Zhenggg\Layout\Row;
use App\Zhenggg\Widgets\Box;
use Illuminate\Routing\Controller;
use Illuminate\Support\MessageBag;

class DepartmentController extends Controller
{
    use ModelForm;

    public function index()
    {
        return Front::content(function (Content $content) {
            $content->header(trans('front::lang.roles'));
            $content->description(trans('front::lang.list'));
            $content->row(function (Row $row) {
                $row->column(7, $this->treeView()->render());

                $row->column(5, function (Column $column) {
                    $form = new \App\Zhenggg\Widgets\Form();
                    $form->action(front_url('department'));
                    $form->text('name', trans('front::lang.name'))->rules('required');

                    $form->hidden('user_id')->default(Front::user()->user_id);

                    $form->select('parent_id','上级部门')->options()->options(Department::selectOptions());

                    $column->append((new Box(trans('front::lang.new'), $form))->style('success'));
                });
            });
        });
    }
    /**
     * @return \App\Zhenggg\Tree
     */
    protected function treeView()
    {
        return Department::tree(function (Tree $tree) {
            $tree->disableCreate();

            $tree->branch(function ($branch) {
                $payload = "&nbsp;<strong>{$branch['name']}</strong>";


                    $payload .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<strong>{$branch['menber_count']}</strong>人";


                return $payload;
            });
        });
    }
    public function edit($id)
    {
        return Front::content(function (Content $content) use ($id) {
            $content->header(trans('front::lang.roles'));
            $content->description(trans('front::lang.edit'));
            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return Front::content(function (Content $content) {
            $content->header(trans('front::lang.roles'));
            $content->description(trans('front::lang.create'));
            $content->body($this->form());
        });
    }

    protected function grid()
    {
        return Front::grid(Department::class, function (Grid $grid) {
            $grid->model()->where('user_id', '=', Front::user()->user_id);

            $grid->name(trans('front::lang.name'))->display(function () {
                if ($this->parent_id) {
                    $postfix =  "     (" . Department::where('id',$this->parent_id)->value('name') . ")";
                } else {
                    $postfix = '    (直属)';
                }
                return $this->name . $postfix;
            });

            $grid->menber_count('人数');


//            $grid->actions(function (Grid\Displayers\Actions $actions) {
//                if ($actions->row->slug == 'main_account') {
//                    $actions->disableDelete();
//                }
//            });

            $grid->tools(function (Grid\Tools $tools) {
                $tools->batch(function (Grid\Tools\BatchActions $actions) {
                    $actions->disableDelete();
                });
            });
        });
    }

    public function form()
    {
        return Front::form(Department::class, function (Form $form) {

            $form->text('name', trans('front::lang.name'))->rules('required');

            $form->hidden('user_id')->default(Front::user()->user_id);
            $form->hidden('id');

            $form->select('parent_id','上级部门')->options()->options(Department::selectOptions());

        });


    }

    public function destroy($id)
    {
        if (!Department::find($id)->children->isEmpty()) {

            return response()->json([
                'status'  => false,
                'message' => '部门下面有子部门，如需删除，请逐级删除',
            ]);
        }

        if (!Menber::where('d_id',$id)->first()->isEmpty()) {

            return response()->json([
                'status'  => false,
                'message' => '部门下面有人员，不能删除',
            ]);
        }
        if ($this->form()->destroy($id)) {
            return response()->json([
                'status'  => true,
                'message' => trans('front::lang.delete_succeeded'),
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => trans('front::lang.delete_failed'),
            ]);
        }
    }
}
