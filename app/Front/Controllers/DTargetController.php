<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/14
 * Time: 15:06
 */

namespace App\Front\Controllers;


use App\DTarget;
use App\Periodical;
use App\Target;
use App\Zhenggg\Auth\Database\Role;
use App\Zhenggg\Facades\Front;
use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Content;
use App\Zhenggg\Form;
use Illuminate\Routing\Controller;

class DTargetController extends Controller
{
    use ModelForm;

    public function index()
    {
        return Front::content(function (Content $content) {

            $content->header('部门目标');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return Front::content(function (Content $content) use ($id) {

            $content->header('部门目标');
            $content->description('修改');

            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return Front::content(function (Content $content) {

            $content->header('部门目标');
            $content->description('新建');

            $content->body($this->form());
        });
    }


    protected function grid()
    {
        return Front::grid(Role::class, function (Grid $grid) {
            $grid->model()->where('user_id', '=', Front::user()->user_id);
            $grid->name("部门");
            $grid->column('z',"刊物：目标/已完成")->display(function () {
                $d_targets =  DTarget::where('d_id',$this->id)->get();
                if ($d_targets) {
                    $h = '';
                    foreach ($d_targets as $d_target) {
                        if ($d_target) {
                            $name =  Periodical::where('id', $d_target['p_id'])->value('name');
                            $h .= $name . "：" . $d_target['num'] . "/" . $d_target['numed']."<br/>";
                        }
                    }
                    return $h;
                }
            });
        });
    }


    protected function form()
    {
        return Front::form(Role::class, function (Form $form) {
            $targets =  Target::where('user_id', '=', Front::user()->user_id)->get();
            if ($targets) {
                foreach ($targets as $key => $target) {
                    if ($target) {
                        $periodical =  Periodical::where('id', $target['p_id'])->first();
                        $form->display('p_name',$periodical->name)->default('剩余未分配目标'.($target['num'] - $target['fnum']).'份');
                        $d_target = DTarget::where('p_id',$target['p_id'])->first();
                        if ($d_target) {
                            $d_target = $d_target->toArray();
                            $form->number('num['.$d_target['id'].']','设置目标份数')->default($d_target['num']);
                        } else {
                            $form->number('num['.'-'.$key.']','设置目标份数');
                        }
                        $form->divide();
                    }
                }
            }
            $form->hidden('user_id')->default(Front::user()->user_id);
            $form->hidden('id');
            $form->saving(function(Form $form){
                if (is_array($form->num)) {

                    foreach ($form->num as $id => $num) {

                        $d_target = DTarget::firstOrNew(['id' => $id]);
                        $d_target->num = $num;
                        $d_target->d_id = $form->id;
                        $d_target->user_id = Front::user()->user_id;
                        $d_target->save();
                    }

                }
            });
        });
    }
}