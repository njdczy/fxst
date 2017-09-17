<?php

namespace App\Menber\Controllers;
use App\Menber\Grid;
use App\Menber\Layout\Content;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Menber as MenberModel;
use App\Menber\Form;
use App\Models\Customer;
use Illuminate\Routing\Controller;
class MyCustomersController extends Controller
{
    public function update($id)
    {
        return $this->form()->update($id);
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
                //->where('u_id', '=', \Menber::user()->id)
                ->orderBy('id','desc');
             //grid columns
            $grid->name("客户名称");
            $grid->hangye("行业类别")->display(function($hangye){
                return Type::where('id',$hangye)->value('name');
            });
            $grid->tel("固定电话");
//            $grid->youbian("邮编");
//            $grid->column('ssq',"省/市/区")->display(function (){
//                if ($this->district) {
//                    $regions = cache('regions');
//                    return  $regions[$this->province] .'/'. $regions[$this->city] . '/' . $regions[$this->district];
//                } else {
//                    return '';
//                }
//            });
//
//            $grid->address("寄送地址");
            $grid->type("性质")->display(function ($type) {
                return Type::where('id', $type)->value('name');
            });
            $grid->contacts("联系人");
            $grid->mobile("电话/手机");
            $grid->source('来源')->display(function(){
                return trans('front::lang.source.' .$this->source. '');
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
            //grid actions
            //grid filters
            $grid->filter(function($filter){
                $filter->disableIdFilter();
                $filter->like('name', '客户');
            });
            //$grid->disableActions();
            $grid->disableCreation();
            $grid->disableBatchDeletion();
        });
    }
    protected function form()
    {
        return \Menber::form(Customer::class, function (Form $form) {

        });
    }
}
