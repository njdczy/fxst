<?php
namespace App\Http\Controllers;


use App\Http\Requests\FormgRequest;
use App\Http\Requests\FormqRequest;
use App\Models\Customer;
use App\Models\Input;
use App\Models\Menber;
use App\Models\Periodical;
use App\Models\Region;


class IndexController extends Controller
{

    public function form($u_id)
    {
        $menber = Menber::find($u_id);
        if ($menber) {
            $periodical = Periodical::where('user_id',$menber->user_id)->get();
            return view('form',['u_id' => $u_id])->with('p', $periodical);
        }
        return '404';
    }

    public function doFormg($u_id,FormgRequest $request)
    {
        $name = $request->input('name');
        $mobile = $request->input('mobile');
        $baozi_id = $request->input('baozi');
        $num = $request->input('num');

        $input_type = $request->input('input_type');
        $piao_status = $request->input('piao_status');

        $address = $request->input('address');
        $region = $request->input('region');
        $region = explode(" ",$region);
        $province = Region::where('name',$region[0])->value('code');
        $city = Region::where('name',$region[1])->value('code');
        $distric = Region::where('name',$region[2])->value('code');
        $menber = Menber::find($u_id);//销售实例
        if ($menber) {
            $customer = new Customer;
            $customer->name =  $name;
            $customer->mobile =  $mobile;
            $customer->contacts =  $name;
            $customer->address =  $address;
            $customer->source =  1;
            $customer->user_id =  $menber->user_id;
            $customer->type = 5;
            $customer->province = $province;
            $customer->city = $city;
            $customer->district = $distric;

            $customer->save();

            //添加订单
            $periodical =  Periodical::find($baozi_id);//报纸实例

            $input = new Input;
            $input->c_id = $customer->id;
            $input->user_id = $menber->user_id;
            $input->u_id = $menber->id;
            $input->menber_name = $menber->name;
            $input->customer_name = $customer->name;
            $input->d_id = $menber->d_id;
            $input->p_id = $periodical->id;
            $input->p_name = $periodical->id;
            $input->source = 1;
            $input->num = $num;
            $input->dis_per = $periodical->per;

            $input->input_type = $input_type;
            $input->piao_status = $piao_status;
            $price_key = $input_type . '_price';
            $input->p_money = $periodical->{$price_key};

            $input->p_amount = ($num * $input->p_money);
            $input->save();

            return redirect()->to('formm/s');
        }

    }


    public function doFormq($u_id,FormqRequest $request)
    {
        $contacts = $request->input('contacts');//q
        $name = $request->input('name');
        $mobile = $request->input('mobile');
        $baozi_id = $request->input('baozi');
        $num = $request->input('num');

        $input_type = $request->input('input_type');
        $piao_status = $request->input('piao_status');

        $address = $request->input('address');
        $region = $request->input('region');
        $region = explode(" ",$region);
        $province = Region::where('name',$region[0])->value('code');
        $city = Region::where('name',$region[1])->value('code');
        $distric = Region::where('name',$region[2])->value('code');
        $menber = Menber::find($u_id);//销售实例
        if ($menber) {
            $customer = new Customer;
            $customer->name = $name;
            $customer->mobile = $mobile;
            $customer->contacts = $contacts;
            $customer->address = $address;
            $customer->source =  1;
            $customer->user_id = $menber->user_id;
            $customer->type = 8;

            $customer->province = $province;
            $customer->city = $city;
            $customer->district = $distric;

            $customer->save();

            //添加订单
            $periodical = Periodical::find($baozi_id);//报纸实例

            $input = new Input;
            $input->c_id = $customer->id;
            $input->user_id = $menber->user_id;
            $input->u_id = $menber->id;
            $input->menber_name = $menber->name;
            $input->customer_name = $customer->name;
            $input->d_id = $menber->d_id;
            $input->p_id = $periodical->id;
            $input->p_name = $periodical->id;
            $input->source = 1;
            $input->num = $num;
            $input->dis_per = $periodical->per;

            $input->input_type = $input_type;
            $input->piao_status = $piao_status;
            $price_key = $input_type . '_price';
            $input->p_money = $periodical->{$price_key};

            $input->p_amount = ($num * $input->p_money);
            $input->save();
            return redirect()->to('formm/s');
        }

    }
}