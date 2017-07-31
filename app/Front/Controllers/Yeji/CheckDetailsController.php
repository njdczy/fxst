<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/21
 * Time: 10:59
 */

namespace App\Front\Controllers\Yeji;

use App\Models\Input;

use App\Models\Menber;

use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use App\Zhenggg\Facades\Front;
use App\Zhenggg\Layout\Content;
//use App\Zhenggg\Controllers\ModelForm;
use Illuminate\Routing\Controller;

class CheckDetailsController extends Controller
{


    public function index($u_id)
    {
        return Front::content(function (Content $content) use ($u_id) {

            $content->header('分成');
            $content->description('结算');

            $content->body($this->grid($u_id));
        });
    }

    protected function grid($u_id)
    {
        return Front::grid(Input::class, function (Grid $grid) use ($u_id) {
            $grid->model()
                ->where('pay_status', 1)
                ->where('user_id', '=', Front::user()->user_id)
                ->where('u_id', '=', $u_id)
                ->where('should_dis_amount', '!=', 0.00);

            $grid->input_sn('订单编号');
            $grid->column('name','客户名称')->display( function () {
                return Menber::where('id', $this->u_id)->value('name');
            });
            $grid->created_at('订单创建时间');
            $grid->column('i_status','订单状态')->display(function () {
                return trans('app.input_status.' .$this->input_status. '');
            });

            $grid->dis_amount('有效金额');
            $grid->should_dis_amount('应结算佣金');

            $states = [
                'off' => ['text' => trans('app.j_status.0')],
                'on' => ['text' => trans('app.j_status.1'), 'disabled' => true],
            ];

            $grid->dis_status('操作')->switch($states);

            $grid->column('');
            $grid->column('');
            $grid->column('');

            $grid->disableCreation();
            $grid->disableExport();

            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            });
            $grid->actions(function ($actions) {
                $actions->disableDelete();
                $actions->disableEdit();
            });

        });
    }

    public function edit($u_id,$id)
    {
        return Front::content(function (Content $content) use ($id) {

            $content->header('分成');
            $content->description('结算');

            $content->body($this->form()->edit($id));
        });
    }

    public function update($u_id,$id)
    {
        return $this->form()->update($id);
    }

    protected function form()
    {
        return Front::form(Input::class, function (Form $form)  {

            $states = [
                'off' => ['text' => trans('app.j_status.0')],
                'on' => ['text' => trans('app.j_status.1'), 'disabled' => true],
            ];

            $form->switch('dis_status')->states($states);
            //$form->text('input_sn');

        });
    }
}