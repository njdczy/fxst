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
use App\Models\Type;
use App\Zhenggg\Form;
use App\Zhenggg\Grid;
use App\Zhenggg\Layout\Content;
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
            $json = '[
    {
        "text": "北京市",
        "value": "110000"
    },
    {
        "text": "天津市",
        "value": "120000"
    },
    {
        "text": "河北省",
        "value": "130000"
    },
    {
        "text": "山西省",
        "value": "140000"
    },
    {
        "text": "内蒙古自治区",
        "value": "150000"
    },
    {
        "text": "辽宁省",
        "value": "210000"
    },
    {
        "text": "吉林省",
        "value": "220000"
    },
    {
        "text": "黑龙江省",
        "value": "230000"
    },
    {
        "text": "上海市",
        "value": "310000"
    },
    {
        "text": "江苏省",
        "value": "320000"
    },
    {
        "text": "浙江省",
        "value": "330000"
    },
    {
        "text": "安徽省",
        "value": "340000"
    },
    {
        "text": "福建省",
        "value": "350000"
    },
    {
        "text": "江西省",
        "value": "360000"
    },
    {
        "text": "山东省",
        "value": "370000"
    },
    {
        "text": "河南省",
        "value": "410000"
    },
    {
        "text": "湖北省",
        "value": "420000"
    },
    {
        "text": "湖南省",
        "value": "430000"
    },
    {
        "text": "广东省",
        "value": "440000"
    },
    {
        "text": "广西壮族自治区",
        "value": "450000"
    },
    {
        "text": "海南省",
        "value": "460000"
    },
    {
        "text": "重庆市",
        "value": "500000"
    },
    {
        "text": "四川省",
        "value": "510000"
    },
    {
        "text": "贵州省",
        "value": "520000"
    },
    {
        "text": "云南省",
        "value": "530000"
    },
    {
        "text": "西藏自治区",
        "value": "540000"
    },
    {
        "text": "陕西省",
        "value": "610000"
    },
    {
        "text": "甘肃省",
        "value": "620000"
    },
    {
        "text": "青海省",
        "value": "630000"
    },
    {
        "text": "宁夏回族自治区",
        "value": "640000"
    },
    {
        "text": "新疆维吾尔自治区",
        "value": "650000"
    },
    {
        "text": "台湾省",
        "value": "710000"
    },
    {
        "text": "香港特别行政区",
        "value": "810000"
    },
    {
        "text": "澳门特别行政区",
        "value": "820000"
    }
]';
            dd(json_decode($json));
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
            $grid->model()->where('user_id', '=', \Front::user()->user_id)
            ->orderBy('created_at','desc');

            $grid->name("客户名称");
            $grid->address("客户（寄送）地址");
            $grid->type("性质")->display(function (){
                return  Type::where('id', $this->type)->value('name');
            });
            $grid->contacts("联系人");
            $grid->mobile("电话/手机");
            $grid->source("来源");

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
            $form->text('name','客户名称')->rules('required')->setWidth('4');
            $form->select('pay_name', '性质')->options(
                Type::whereIn ('user_id', [\Front::user()->user_id,0])
                    ->where('type', '=', 'customer_type')
                    ->pluck('name', 'id')
            )->rules('required')->setWidth('4');
            $form->text('contacts','联系人')->rules('required')->setWidth('4');
            $form->text('mobile','电话/手机')->setWidth('4');
            $form->text('address','客户（寄送）地址');
            $form->text('source','来源');
            $form->hidden('user_id')->default(\Front::user()->user_id);

            $form->divide();

            $form->hasMany('customer_piaos', '开票信息',function (Form\NestedForm $form) {
                $form->text('name','名称')->setWidth('4');
                $form->text('hao','纳税识别号')->setWidth('4');
                $form->text('addr','地址')->setWidth('4');
                $form->text('phone','电话')->setWidth('4');
                $form->text('bank','银行')->setWidth('4');
                $form->text('bank_account','账号')->setWidth('4');
                $form->hidden('user_id')->default(\Front::user()->user_id);
            });

        });
    }
}