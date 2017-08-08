<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/19
 * Time: 14:17
 */

namespace App\Front\Controllers\Yeji;

use App\Models\Department;
use App\Models\DPer;
use App\Models\Periodical;
use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Content;
use App\Zhenggg\Controllers\ModelForm;
use Illuminate\Routing\Controller;

class DdisperController extends Controller
{
    use ModelForm;

    public function index()
    {
        return \Front::content(function (Content $content) {

            $content->header('设置');
            $content->description('部门比例');

            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return \Front::content(function (Content $content) use ($id) {

            $content->header('设置');
            $content->description('部门比例');
            $periodicals = Periodical::where('user_id', \Front::user()->user_id)->get();

            $content->body($this->form($periodicals,$id)->edit($id));
        });
    }

    public function update($id)
    {
        return $this->form('',$id)->update($id);
    }

    protected function grid()
    {
        return \Front::grid(Department::class, function (Grid $grid) {
            $grid->model()->where('user_id', '=', \Front::user()->user_id);
            $grid->column('');
            $grid->name("部门");
            $grid->column('detail', "比例详情")->display(function () {
                $periodicals = Periodical::where('user_id', \Front::user()->user_id)->get();
                if ($periodicals) {
                    $h = '';
                    foreach ($periodicals as $periodical) {
                        $d_per = DPer::where('user_id', \Front::user()->user_id)
                            ->where('d_id', $this->id)
                            ->where('p_id', $periodical['id'])
                            ->first();

                        if ($d_per) {
                            $h .= $periodical['name'] . "：" . $d_per->per . "%" . "<br/>";
                        } else {
                            $h .= $periodical['name'] . "：" . $periodical['per'] . "%" . "  (未设置，默认使用总比例) <br/>";
                        }
                    }
                    return $h;
                }
            });
            $grid->disableCreation();
            $grid->disableExport();
            $grid->disableBatchDeletion();
            $grid->disableRowSelector();
            $grid->actions(function ($actions) {
                $actions->disableDelete();
            });
            $grid->filter(function ($filter) {
                $filter->disableIdFilter();
                $filter->like('name', '部门');
            });
        });
    }

    protected function form($periodicals = '',$id = '')
    {
        return \Front::form(Department::class, function (Form $form) use ($periodicals , $id) {

            $form->display('name', '部门');
            if ($periodicals) {
                foreach ($periodicals as $key => $periodical) {
                    $d_per = DPer::where('user_id', \Front::user()->user_id)
                        ->where('p_id', $periodical->id)
                        ->where('d_id', $id)
                        ->first();
                    $form->number($periodical->name)
                        ->attribute(['name' => 'periodical[' . $periodical->id . ']'])
                        ->default($d_per?$d_per->per:$periodical->per)
                        ->rules('numeric|min:0|max:100');
                }
            }
            $form->saving(function (Form $form) use ($id) {

                if (is_array($form->periodical)) {
                    foreach ($form->periodical as $p_id => $per) {
                        $d_per = DPer::firstOrNew(['user_id'=>\Front::user()->user_id,'p_id'=>$p_id,'d_id'=>$id]);
                        $d_per->per = $per;
                        $d_per->save();
                    }
                }
            });
        });
    }
}