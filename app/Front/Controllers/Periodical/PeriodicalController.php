<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/13
 * Time: 14:26
 */

namespace App\Front\Controllers\Periodical;

use App\Front\Controllers\ModelForm;
use App\Models\Baoshe;
use App\Models\Periodical;
use App\Zhenggg\Facades\Front;
use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Content;
use Illuminate\Routing\Controller;

class PeriodicalController extends Controller
{
    use ModelForm;

    public function index()
    {
        return Front::content(function (Content $content) {

            $content->header('刊物');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return Front::content(function (Content $content) use ($id) {

            $content->header('刊物');
            $content->description('修改');

            $content->body($this->form()->edit($id));
        });
    }

    public function create()
    {
        return Front::content(function (Content $content) {

            $content->header('刊物');
            $content->description('新建');

            $content->body($this->form());
        });
    }


    protected function grid()
    {
        return Front::grid(Periodical::class, function (Grid $grid) {
            $grid->model()->where('user_id', '=', Front::user()->user_id);
            $grid->name("刊物名称");
            $grid->baoshe()->name('所属报社');
            $grid->price("原价格");
            $grid->c_price("优惠价格");
            $grid->per('基准分成比例(百分比)');

            $grid->disableExport();
            $grid->disableRowSelector();

            $grid->filter(function($filter){

                $filter->disableIdFilter();

                $filter->like('name', '刊物名称');

                $filter->is('baoshe_id', '所属报社')->select(Baoshe::where('user_id', Front::user()->user_id)->pluck('name', 'id'));

            });
        });
    }


    protected function form()
    {
        return Front::form(Periodical::class, function (Form $form) {
            $form->text('name','刊物名称')->rules('required');
            $form->number('price','原价格/份')->rules('required');
            $form->number('c_price','优惠价格/份')->rules('required');
            $form->number('per','基准分成比例(百分比)')->help('填写0到100')->rules('required|between:0,100');
            $form->select('baoshe_id','所属报社')
                ->options(
                    Baoshe::where('user_id', Front::user()->user_id)
                        ->pluck('name', 'id')
                )->rules('required');

            $form->hidden('user_id')->default(Front::user()->user_id);

        });
    }

    public function destroy($id)
    {
        if ($this->form()->destroy($id)) {
            if (Periodical::where('id',$id)->exists()) {
                return response()->json([
                    'status'  => false,
                    'message' => '刊物下有目标，不能删除',
                ]);
            }
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