<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/13
 * Time: 10:10
 */

namespace App\Front\Controllers\Customer;

use App\Front\Controllers\ModelForm;
use App\Models\Customer;
use App\Models\Region;
use App\Models\Type;
use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Content;
use App\Zhenggg\Widgets\Table;
use Illuminate\Routing\Controller;

class CustomerController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return \Front::content(function (Content $content) {
            $content->header('客户');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return \Front::content(function (Content $content) use ($id) {

            $content->header('客户');
            $content->description('修改');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return \Front::content(function (Content $content) {

            $content->header('客户');
            $content->description('新建');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return \Front::grid(Customer::class, function (Grid $grid) {
            //grid model filters
            $grid->model()->where('user_id', '=', \Front::user()->user_id)
            ->orderBy('created_at','desc');

            //grid columns
            $grid->name("客户名称");
            $grid->hangye("行业类别")->display(function($hangye){
                return Type::where('id',$hangye)->value('name');
            });
            $grid->tel("固定电话");
            $grid->youbian("邮编");
            $grid->column('ssq',"省/市/区")->display(function (){
                if ($this->province) {
                    $regions = cache('regions');
                    return  $regions[$this->province] .'/'. $regions[$this->city] . '/' . $regions[$this->district];
                } else {
                    return '';
                }
            });
            $grid->address("客户（寄送）地址");
            $grid->type("性质")->display(function ($type){
                return  Type::where('id', $type)->value('name');
            });
            $grid->contacts("联系人");
            $grid->mobile("电话/手机");
            $grid->source('来源')->display(function(){
                return trans('front::lang.source.' .$this->source. '');
            });
            $grid->customer_piao()->column('开票信息')->expand(function () {
                $piao = (array) $this->customer_piao;
                $piao_array['名称'] = $piao['name'];
                $piao_array['纳税识别号'] = $piao['hao'];
                $piao_array['地址'] = $piao['addr'];
                $piao_array['电话'] = $piao['phone'];
                $piao_array['开户行'] = $piao['bank'];
                $piao_array['账号'] = $piao['bank_account'];
                return new Table([], $piao_array);
            }, '查看');

            //grid actions


            //grid filters
            $grid->filter(function($filter){

                $filter->disableIdFilter();

                $filter->like('customer_name', '客户');
            });

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return \Front::form(Customer::class, function (Form $form) {
            $form->text('name','客户名称')->rules('required')->setWidth('3');
            $form->select('hangye','行业类别')->options(
                Type::where('type','hangye')->whereIn('user_id',[0,\Front::user()->user_id])->pluck('name','id')
            )->rules('required')->setWidth('2');
            $form->text('tel','固定电话')->setWidth('2');
            $form->text('youbian','邮编')->rules('required|digits:6')->setWidth('2');
            $form->select('type', '性质')->options(
                Type::whereIn ('user_id', [\Front::user()->user_id,0])
                    ->where('type', '=', 'customer_type')
                    ->pluck('name', 'id')
            )->rules('required')->setWidth('2');
            $form->text('contacts','联系人')->rules('required')->setWidth('3');
            $form->text('mobile','电话/手机')->setWidth('3');

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

            $form->text('address','客户（寄送）地址')->setWidth('4');
            $form->hidden('user_id')->default(\Front::user()->user_id)->setWidth('4');

            $form->divide();
            $form->html("<div class=\"col-md-2\"><h4 class=\"pull-right\">开票信息</h4></div>");
            $form->divide();

            $form->hidden('customer_piao.user_id')->default(\Front::user()->user_id)->setWidth('4');
            $form->text('customer_piao.name','名称')->setWidth('4');
            $form->text('customer_piao.hao','纳税识别号')->setWidth('4');
            $form->text('customer_piao.addr','地址')->setWidth('4');
            $form->text('customer_piao.phone','电话')->setWidth('4');
            $form->text('customer_piao.bank','开户行')->setWidth('4');
            $form->text('customer_piao.bank_account','账号')->setWidth('4');
        });
    }
}