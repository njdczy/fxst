<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/4
 * Time: 9:54
 */

namespace App\Front\Controllers\Target;

use App\Models\Department;
use App\Models\Target;
use App\Models\TargetD;
use App\Zhenggg\Layout\Content;
use App\Zhenggg\Form;
use Carbon\Carbon;
use Illuminate\Support\MessageBag;
use Illuminate\Routing\Controller;

class TargetDController extends Controller
{

    public function create($target_id)
    {
        return \Front::content(function (Content $content) use ($target_id) {

            $content->header('子目标');
            $content->description('新建');

            $content->body($this->form($target_id));
        });
    }

    public function store($target_id)
    {
        return $this->form($target_id)->store();
    }

    public function edit($target_id, $id)
    {
        return \Front::content(function (Content $content) use ($target_id, $id) {

            $content->header('子目标');
            $content->description('修改');

            $content->body($this->form($target_id)->edit($id));
        });
    }

    public function update($target_id, $id)
    {
        return $this->form($target_id)->update($id);
    }

    protected function form($target_id)
    {
        return \Front::form(TargetD::class, function (Form $form) use ($target_id) {
            $target = Target::find($target_id);
            $form->display('p_name', '刊物')->setWidth(3)->default($target->periodical->name);
            $form->display('time', '目标时间段')->setWidth(3)
                ->default(Carbon::parse($target->s_time)->format('Y-m-d') . '----' . Carbon::parse($target->e_time)->format('Y-m-d'));

            $form->display('t_num', '总目标份数')->setWidth(1)->default($target->num);
            $form->display('t_numed', '总已完成数')->setWidth(1)->default($target->numed);
            $form->divide();

            $form->hidden('user_id')->default(\Front::user()->user_id);
            $form->hidden('p_id')->default($target->periodical->id);
            $form->hidden('target_id')->default($target->id);
            $form->hidden('parent_d_id');
            $form->hidden('d_name');

            $form->select('d_id', '部门')->options(
                Department::selectOptionsForNoroot()
            )->setWidth(4);

            $form->number('num', '设置部门目标份数(按年订阅数)')->rules('required|numeric|min:1|max:1000000000');
            if (isset($form->model()->numed)) {
                $form->display('numed', '已完成数(按年订阅数)')->setWidth(1)->default($form->model()->numed);
            }

            $form->text('money', '设置部门目标金额')->setWidth(3)->rules('required|numeric|min:1|max:1000000000');
            if (isset($form->model()->moneyed)) {
                $form->display('moneyed', '部门已完金额')->setWidth(1)->default($form->model()->moneyed);
            }

            $form->creating(function (Form $form) {
                if (
                TargetD::where('p_id', '=', $form->p_id)
                    ->where('target_id', '=', $form->target_id)
                    ->where('d_id', '=', $form->d_id)
                    ->exists()

                ) {
                    $error = new MessageBag([
                        'title' => '子目标重复',
                        'message' => '',
                    ]);
                    return redirect()->back()->with(compact('error'));
                }

            });
            $form->saving(function (Form $form) {
                $department = Department::find($form->d_id);
                $form->d_name = $department->name;

                $parent_d_id = $department->parent ? $department->parent->id : 0;

                $form->parent_d_id = $parent_d_id;
            });
            $form->saved(function (Form $form) {
                $success = new MessageBag([
                    'title' => '编辑子目标成功',
                    'message' => '',
                ]);
                return redirect()->to(\Front::url('target'))->with(compact('success'));
            });
        });
    }

    public function destroy($target_id,$id)
    {
        if ($this->form($target_id)->destroy($id)) {
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