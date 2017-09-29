<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/27
 * Time: 10:04
 */

namespace App\Menber\Controllers;

use App\Menber\Grid;
use App\Menber\Layout\Content;
use App\Menber\Widgets\Table;
use App\Models\Customer;
use App\Models\Department;
use App\Menber\Form;
use App\Models\Menber;
use App\Models\Periodical;
use App\Models\Region;
use App\Models\Type;
use Illuminate\Routing\Controller;
class MyCustomersController extends Controller
{
    public function update($id)
    {
        return $this->form()->update($id);
    }
    public function edit($id)
    {
        return \Menber::content(function (Content $content) use ($id) {

            $content->header('客户');
            $content->description('修改');

            $content->body($this->form()->edit($id));
        });
    }
    public function index()
    {

        return \Menber::content(function (Content $content) {
            $content->header('发行管理系统');
            $content->description(config('menber.logo', config('menber.name')));
            $content->body($this->grid());

        });
    }


    protected function grid()
    {
        return \Menber::grid(Customer::class, function (Grid $grid) {
            $grid->model()
                ->where('user_id', '=', \Menber::user()->user_id)
                ->where('u_id', '=', \Menber::user()->id)
                ->orderBy('id','desc');

            //grid columns
            $grid->name("客户名称");
            $grid->hangye("行业类别")->display(function($hangye){
                return Type::where('id',$hangye)->value('name');
            });
            $grid->tel("固定电话");
            $grid->type("性质")->display(function ($type) {
                return Type::where('id', $type)->value('name');
            });
            $grid->contacts("联系人");
            $grid->mobile("电话/手机");
            $grid->source('来源')->display(function(){
                return trans('menber::lang.source.' .$this->source. '');
            });
            $grid->customer_piao()->column('开票信息')->expand(function () {
                $piao = (array) $this->customer_piao;
                if ($piao) {
                    $piao_array['名称'] = $piao['name'];
                    $piao_array['纳税识别号'] = $piao['hao'];
                    $piao_array['地址'] = $piao['addr'];
                    $piao_array['电话'] = $piao['phone'];
                    $piao_array['开户行'] = $piao['bank'];
                    $piao_array['账号'] = $piao['bank_account'];
                    return new Table([], $piao_array);
                }
            }, '查看');

            $grid->filter(function($filter){
                $filter->disableIdFilter();

                $filter->like('name', '客户');
            });
            $grid->disableActions();
            $grid->disableCreation();
            $grid->disableBatchDeletion();
        });
    }

    protected function form()
    {
        return \Menber::form(Customer::class, function (Form $form) {
            $form->text('name','客户名称')->rules('required')->setWidth('3');

            $form->select('u_id','所属发行人')->options(
                Menber::where('user_id',\Menber::user()->user_id)->pluck('name','id')
            )->rules('required')->setWidth('2');

            $form->select('hangye','行业类别')->options(
                Type::where('type','hangye')->whereIn('user_id',[0,\Menber::user()->user_id])->pluck('name','id')
            )->rules('required')->setWidth('2');
            $form->text('tel','固定电话')->setWidth('2');
            $form->text('youbian','邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;编')->rules('required|digits:6')->setWidth('2');
            $form->select('type', '性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;质')->options(
                Type::whereIn ('user_id', [\Menber::user()->user_id,0])
                    ->where('type', '=', 'customer_type')
                    ->pluck('name', 'id')
            )->rules('required')->setWidth('2');
            $form->text('contacts','联&nbsp;&nbsp;系&nbsp;&nbsp;人')->rules('required')->setWidth('3');
            $form->text('mobile','电话/手机')->setWidth('3');
            $form->divide();
            $form->html("<h4 class=\"pull-left\"><b>配送地址（多）</b></h4>");
            $form->hasMany('customer_addresses', '',function (Form\NestedForm $form) {
                // first level
                $form->select('province','省')->options(
                    Region::province()->pluck('name', 'code')
                )->load('city', '/front/api/region/city')->setWidth('2');
                // second level
                $form->select('city','市')->options(function ($id) {
                    return Region::options($id);
                })->load('district', '/front/api/region/district')->setWidth('2');
                // third level
                $form->select('district','区')->options(function ($id) {
                    return Region::options($id);
                })->setWidth('2');
                $form->text('address','详细地址')->setWidth('4');
                $form->hidden('user_id')->default(\Menber::user()->user_id);

            });

            $form->hidden('user_id')->default(\Menber::user()->user_id)->setWidth('4');

            $form->divide();

            $form->html("<h4 class=\"pull-left\"><b>开票信息</b></h4>");
            $form->divide();

            $form->hidden('customer_piao.user_id')->default(\Menber::user()->user_id)->setWidth('4');
            $form->text('customer_piao.name','名&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称')->setWidth('4');
            $form->text('customer_piao.hao','纳税识别号')->setWidth('4');
            $form->text('customer_piao.addr','地&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;址')->setWidth('4');
            $form->text('customer_piao.phone','电&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;话')->setWidth('4');
            $form->text('customer_piao.bank','开&nbsp;&nbsp;户&nbsp;&nbsp;行')->setWidth('4');
            $form->text('customer_piao.bank_account','账&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号')->setWidth('4');
        });
    }
}
