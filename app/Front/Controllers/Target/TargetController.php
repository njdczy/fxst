<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/13
 * Time: 17:41
 */

namespace App\Front\Controllers\Target;

use App\Front\Controllers\ModelForm;
use App\Models\Department;
use App\Models\Periodical;
use App\Models\Target;
use App\Models\TargetD;
use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Content;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\MessageBag;

class TargetController extends Controller
{
    protected $trees = [];

    use ModelForm;

    public function index()
    {
        return \Front::content(function (Content $content) {
            $content->header('目标列表');
            $content->description('列表');

            $targets = Target::where('user_id', \Front::user()->user_id)->get();
            $p_targets = $targets->groupBy('p_id');
            $p_targets->each(function ($targets, $k) {

                $targets->each(function ($target, $key) {
                    $target_d = new TargetD;
                    $this->trees[$target->id] = $this->depth($target_d->toTree(['p_id'=>$target->periodical->id,'target_id'=>$target->id]));
                });

            });
            $trees = $this->trees;
            $content->body(view('front::zhenggg.target',compact('p_targets','trees'))->render());
        });


        return \Front::content(function (Content $content) {

            $confirm = '该目标已完成的的数量将无法关联到之后添加的目标，确定要删除目标吗？';
            $script = <<<SCRIPT
<script>
    $('.grid-row-delete').unbind('click').click(function() {
        if(confirm("{$confirm}")) {
            $.ajax({
                method: 'post',
                url: $(this).data('url'),
                data: {
                    _method:'delete',
                    _token:LA.token,
                },
                success: function (data) {
                    $.pjax.reload('#pjax-container');

                    if (typeof data === 'object') {
                        if (data.status) {
                            toastr.success(data.message);
                        } else {
                            toastr.error(data.message);
                        }
                    }
                }
            });
        }
    });
</script>
SCRIPT;

        });
    }

    protected function depth($array)
    {
        static $res = [];
        static $depth = 1;
        foreach ($array as $key => $value) {
            $value['depth'] = $depth++;
            $res[] = $value;
            if(isset($value['children'])){
                $this->depth($value['children']);
            }
            $depth = 1;
        }
        return $res;
    }

    public function edit($id)
    {
        return \Front::content(function (Content $content) use ($id) {

            $content->header('目标');
            $content->description('修改');

            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return \Front::content(function (Content $content) {

            $content->header('目标');
            $content->description('新建');

            $content->body($this->form());
        });
    }


    protected function grid()
    {
        return \Front::grid(Periodical::class, function (Grid $grid) {
            $grid->model()->where('user_id', '=', \Front::user()->user_id);

            $grid->name('刊物')->label();
            $grid->targets("部门&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            时间段&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            目标数&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            已完成")
                ->map(function ($target) {
                    $num = $target['num'];
                    $numed = $target['numed'];
                    $name = Department::where('user_id', '=', \Front::user()->user_id)->where('id', $target['d_id'])->value('name') ?: '总目标';

                    $date = Carbon::parse($target['s_time'])->format('Y-m-d') . '--' . Carbon::parse($target['e_time'])->format('Y-m-d');
                    return "<strong><i style='display:inline-block;width: 6rem;margin-left: 0.05rem;font-style: normal;'>$name</i></strong>
<span style='display:inline-block;width: 140px;margin-left: 63px;'>$date</span>
<strong style='display:inline-block;width: 80px;text-align: center;margin-left: 95px;'>$num</strong><strong style='display:inline-block;width: 80px;text-align: center;margin-left: 120px;'>$numed</strong>
<a style='padding-left: 80px;' href='/front/target/$target[id]/edit'>
    <i class='fa fa-edit'></i>
</a>
<a style='padding-left: 60px;'  href=\"javascript:void(0);\" data-url=\"/front/target/$target[id]\" data-id=\"$target[id]\" class=\"grid-row-delete\">
    <i class=\"fa fa-trash\"></i>
</a>
";
                })->implode('<br /><hr />');
            $grid->column('')->display(function () {
                $confirm = '该目标已完成的的数量将无法关联到之后添加的目标，确定要删除目标吗？';
                return <<<SCRIPT
<script>
    $('.grid-row-delete').unbind('click').click(function() {
        if(confirm("{$confirm}")) {
            $.ajax({
                method: 'post',
                url: $(this).data('url'),
                data: {
                    _method:'delete',
                    _token:LA.token,
                },
                success: function (data) {
                    $.pjax.reload('#pjax-container');

                    if (typeof data === 'object') {
                        if (data.status) {
                            toastr.success(data.message);
                        } else {
                            toastr.error(data.message);
                        }
                    }
                }
            });
        }
    });
</script>
SCRIPT;

            });

            $grid->tools(function (Grid\Tools $tools) {
                $tools->batch(function (Grid\Tools\BatchActions $actions) {
                    $actions->disableDelete();
                });
            });
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
                $actions->disableEdit();
            });
            $grid->disableExport();
        });
    }


    protected function form()
    {


        return \Front::form(Target::class, function (Form $form) {
            $form->select('p_id', '刊物')->options(
                Periodical::where('user_id', '=', \Front::user()->user_id)
                    ->pluck('name', 'id')
            )->setWidth(4);

            $form->dateRange('s_time', 'e_time', '目标时间段');
            $form->number('num', '设置总目标份数(按年订阅数)')->rules('required|numeric|min:1');
            if (isset($form->model()->numed)) {
                $form->display('numed', '总已完成数(按年订阅数)')->setWidth(1)->default($form->model()->numed);
            }
            $form->text('money', '设置总目标金额')->setWidth(3)->rules('required|numeric|min:1');
            if (isset($form->model()->moneyed)) {
                $form->display('moneyed', '总已完金额')->setWidth(1)->default($form->model()->moneyed);
            }
            $form->hidden('user_id')->default(\Front::user()->user_id);

            $form->creating(function (Form $form) {
                if (
                Target::where('p_id', '=', $form->p_id)
                    ->where(function ($query) use ($form) {
                        $query->whereBetween('s_time', [$form->s_time, $form->e_time])
                            ->OrwhereBetween('e_time', [$form->s_time, $form->e_time]);
                    })->exists()

                ) {
                    $error = new MessageBag([
                        'title' => '相同刊物和目标时间段重复',
                        'message' => '',
                    ]);
                    return redirect()->back()->with(compact('error'));
                }

            });

        });
    }
}