<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/4
 * Time: 15:17
 */

namespace App\Front\Controllers\Target;

use App\Models\Menber;
use App\Models\Target;
use App\Models\TargetD;
use App\Models\TargetM;
use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Content;
use App\Zhenggg\Layout\Row;
use Illuminate\Routing\Controller;

class TargetMController extends Controller
{
    public function index($target_id, $targetd_id)
    {
        $target_d = TargetD::find($targetd_id);
        $target_m_u_ids = TargetM::where('user_id', \Front::user()->user_id)
            ->where('t_id', $target_id)
            ->where('t_d_id', $targetd_id)
            ->pluck('u_id');
        $menber_ids = Menber::where('d_id', $target_d->d_id)->pluck('id');
        $menber_names = Menber::where('d_id', $target_d->d_id)->pluck('name')->toArray();

        $diff_u_ids = $menber_ids->diff($target_m_u_ids); //menber比target_m的u_id

        $diff_u_ids->each(function ($u_id, $key) use ($target_d, $target_id, $targetd_id,$menber_names) {

            TargetM::create([
                'user_id' => \Front::user()->user_id,
                'user_name' => $menber_names[$key],
                'u_id' => $u_id,
                't_id' => $target_id,
                't_d_id' => $targetd_id,
            ]);
        });

        return \Front::content(function (Content $content) use ($target_id, $targetd_id) {
            $target_d = TargetD::find($targetd_id);
            $target = Target::find($target_id);
            $periodical_name = $target->periodical->name;
            $time = \Carbon::parse($target->s_time)->format('Y-m-d') . '----' . \Carbon::parse($target->e_time)->format('Y-m-d');
            $content->header('发行人目标');
            $content->description('列表');

            $content->row(function(Row $row) use ($target_d,$periodical_name,$time) {
                $row->column(1,'');
                $row->column(3,'<h3>刊物：<strong style="font-size: 14px;font-weight: normal;">'.$periodical_name.'</strong></h3>');
                $row->column(3, '<h3>时间段： <strong style="font-size: 14px;font-weight: normal;">'.$time.'</strong></h3>');
                $row->column(3, '<h3>部门：<strong style="font-size: 14px;font-weight: normal;">'.$target_d->d_name.'</strong></h3>');

            });
            $content->body($this->grid($target_id, $targetd_id));
        });
    }

    protected function grid($target_id, $targetd_id)
    {
        return \Front::grid(TargetM::class, function (Grid $grid) use ($target_id, $targetd_id) {
            $grid->model()->where('user_id', '=', \Front::user()->user_id)
                ->where('t_id', '=', $target_id)
                ->where('t_d_id', '=', $targetd_id);

            $grid->column('user_name', '发行人')->display(function () {
                $user_name = Menber::where('id', $this->u_id)->value('name');
                if ($user_name) {
                    return $user_name;
                } else {
                    return $this->user_name . '(已删除)';
                }
            });
            $grid->column('num', '目标数');
            $grid->column('numed', '完成数');
            $grid->column('details', '完成详情');

            $grid->disableCreation();
            $grid->tools(function (Grid\Tools $tools) {
                $tools->batch(function (Grid\Tools\BatchActions $actions) {
                    $actions->disableDelete();
                });
            });
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableDelete();
            });
            $grid->filter(function ($filter) {
                $filter->disableIdFilter();
                $filter->like('user_name', '发行人');
            });
        });
    }

    public function edit($target_id, $targetd_id,$id)
    {
        return \Front::content(function (Content $content) use ($target_id, $targetd_id,$id) {

            $content->header('发行人目标');
            $content->description('修改');

            $content->body($this->form($target_id,$targetd_id)->edit($id));
        });
    }

    public function update($target_id, $targetd_id,$id)
    {
        return $this->form($target_id,$targetd_id)->update($id);
    }


    protected function form($target_id,$targetd_id)
    {
        return \Front::form(TargetM::class, function (Form $form) use ($target_id,$targetd_id) {
            $target = Target::find($target_id);
            $target_d = TargetD::find($targetd_id);
            $form->display('p_name', '刊物')->setWidth(3)->default($target->periodical->name);
            $form->display('time', '目标时间段')->setWidth(3)
                ->default(\Carbon::parse($target->s_time)->format('Y-m-d') . '----' . \Carbon::parse($target->e_time)->format('Y-m-d'));

            $form->display('t_num', '总目标份数')->setWidth(1)->default($target->num);

            $form->divide();
            $form->display('d_id', '部门')->setWidth(3)->default($target_d->d_name);
            $form->display('d_num', '部门目标份数')->setWidth(3)->default($target_d->num);
            $form->divide();

            $form->number('num', '目标数');
            $form->display('numed', '已完成')->setWidth(1)->default(0);


        });
    }

}