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
use App\Zhenggg\Facades\Front;
use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Content;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\MessageBag;

class TargetController extends Controller
{
    use ModelForm;

    public function index()
    {
        return Front::content(function (Content $content) {

            $content->header('目标');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return Front::content(function (Content $content) use ($id) {

            $content->header('目标');
            $content->description('修改');

            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return Front::content(function (Content $content) {

            $content->header('目标');
            $content->description('新建');

            $content->body($this->form());
        });
    }


    protected function grid()
    {
        return Front::grid(Periodical::class, function (Grid $grid) {
            $grid->model()->where('user_id', '=', Front::user()->user_id);
            $grid->name('刊物');

            $grid->targets("部门/时间段/目标数/已完成")->map(function ($target) {
                $num = $target['num'];
                $numed = $target['numed'];
                $name = Department::where('user_id', '=', Front::user()->user_id)->where('id',$target['d_id'])->value('name')?:'总';

                $date =  Carbon::parse($target['s_time'])->format('Y-m-d'). '--' . Carbon::parse($target['e_time'])->format('Y-m-d');
                return "<strong><i style='display:inline-block;width: 100px;'>$name</i></strong>
<span style='display:inline-block;width: 140px;'>$date</span>
<strong style='display:inline-block;width: 70px;text-align: center;'>$num/$numed</strong>
<a style='padding-left: 50px;' href='/front/target/$target[id]/edit'>
    <i class='fa fa-edit'></i>
</a>
<a style='padding-left: 50px;'  href=\"javascript:void(0);\" data-url=\"/front/target/$target[id]\" data-id=\"$target[id]\" class=\"grid-row-delete\">
    <i class=\"fa fa-trash\"></i>
</a>
";
            })->implode('<br />');
            $grid->column('')->display(function () {
                $confirm = trans('front::lang.delete_confirm');
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
        return Front::form(Target::class, function (Form $form) {
            $form->select('p_id', '刊物')->options(
                Periodical::where('user_id', '=', Front::user()->user_id)
                    ->pluck('name', 'id')
            );
            $form->select('d_id', '部门')->options(
                Department::selectOptions()
            );
            $form->dateRange('s_time', 'e_time', '目标时间段');
            $form->number('num','目标份数');
            $form->hidden('user_id')->default(Front::user()->user_id);
            $form->creating(function (Form $form) {
                if (Target::where('p_id', '=', $form->p_id)
                    ->where('d_id', '=', $form->d_id)
                    ->whereNotBetween('s_time', [$form->s_time,$form->e_time])
                    ->whereNotBetween('e_time', [$form->s_time,$form->e_time])->exists()
                ) {
                    $error = new MessageBag([
                        'title' => '相同刊物和部门的目标时间段重复',
                        'message' => '',
                    ]);
                    return redirect()->back()->with(compact('error'));
                }
            });

        });
    }
}