<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/13
 * Time: 14:26
 */

namespace App\Front\Controllers\Base;

use App\Front\Controllers\ModelForm;
use App\Models\Baoshe;
use App\Models\Periodical;
use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Content;
use Illuminate\Routing\Controller;

class PeriodicalController extends Controller
{
    use ModelForm;

    public function index()
    {
        return \Front::content(function (Content $content) {

            $content->header('刊物');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return \Front::content(function (Content $content) use ($id) {

            $content->header('刊物');
            $content->description('修改');

            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return \Front::content(function (Content $content) {

            $content->header('刊物');
            $content->description('新建');

            $content->body($this->form());
        });
    }


    protected function grid()
    {
        return \Front::grid(Periodical::class, function (Grid $grid) {
            $grid->model()->where('user_id', '=', \Front::user()->user_id);
            $grid->column('');
            $grid->name("刊物名称");
            $grid->baoshe()->name('所属报社');
            $grid->m_price("月价格");
            $grid->j_price("季度价格");
            $grid->b_price("半年价格");
            $grid->y_price("一年价格");
            $grid->per('基准分成比例(百分比)')->display(function(){
                return $this->per . "%";
            });

            $grid->disableExport();
            $grid->disableRowSelector();

            $grid->filter(function($filter){

                $filter->disableIdFilter();

                $filter->like('name', '刊物名称');

                $filter->is('baoshe_id', '所属报社')->select(Baoshe::where('user_id', \Front::user()->user_id)->pluck('name', 'id'));

            });
        });
    }


    protected function form()
    {
        return \Front::form(Periodical::class, function (Form $form) {
            $form->text('name','刊物名称')->rules('required')->setWidth(4)->help('如：江苏经济报');
            $form->number('m_price','月价格/份')->rules('required|numeric');
            $form->number('j_price','季度价格/份')->rules('required|numeric');
            $form->number('b_price','半年价格/份')->rules('required|numeric');
            $form->number('y_price','一年价格/份')->rules('required|numeric');
            $form->text('per','基准分成比例(百分比)')->rules('required|numeric|between:0,100')->setWidth(4)->help('填写0到100');
            $form->select('baoshe_id','所属报社')
                ->options(
                    Baoshe::where('user_id', \Front::user()->user_id)
                        ->pluck('name', 'id')
                )->rules('required');

            $form->hidden('user_id')->default(\Front::user()->user_id);

        });
    }

    public function destroy($id)
    {
        if (!Periodical::find($id)->targets->isEmpty()) {
            return response()->json([
                'status'  => false,
                'message' => '刊物下有目标，不能删除',
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