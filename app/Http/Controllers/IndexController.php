<?php
namespace App\Http\Controllers;


use App\Http\Requests\FormmgRequest;
use App\Http\Requests\FormmqRequest;
use App\Models\Customer;
use App\Models\Input;
use App\Models\Menber;
use App\Models\Periodical;


class IndexController extends Controller
{
    public function formm($u_id)
    {
        $periodical = Periodical::all();
        return view('formm',['u_id' => $u_id])->with('p', $periodical);
    }

    public function formpc($u_id)
    {
        $periodical = Periodical::all();
        return view('form',['u_id' => $u_id])->with('p', $periodical);
    }

    public function doFormmg($u_id,FormmgRequest $request)
    {

        $name = $request->input('name');
        $mobile = $request->input('mobile');
        $baozi_id = $request->input('baozi');
        $num = $request->input('num');
        $address = $request->input('address');
        $menber = Menber::find($u_id);//销售实例
        if ($menber) {
            $customer = new Customer;
            $customer->name =  $name;
            $customer->mobile =  $mobile;
            $customer->contacts =  $name;
            $customer->address =  $address;
            $customer->source =  '微信';
            $customer->user_id =  $menber->user_id;
            $customer->save();

            //添加订单
            $periodical =  Periodical::find($baozi_id);//报纸实例

            $input = new Input;
            $input->c_id = $customer->id;
            $input->user_id = $menber->user_id;
            $input->u_id = $menber->id;
            $input->menber_name = $menber->name;
            $input->d_id = $menber->d_id;
            $input->p_id = $periodical->id;
            $input->p_name = $periodical->id;
            $input->source = 1;
            $input->num = $num;
            $input->dis_per = $periodical->per;
            $input->p_money = $periodical->c_price != 0? $periodical->c_price:$periodical->price;
            $input->p_amount = ($num * $input->p_money);
            $input->pay_name = '无';
            $input->save();

            return redirect()->to('formm/s');
        }

    }


    public function doFormmq($u_id,FormmqRequest $request)
    {
        $contacts = $request->input('contacts');//q
        $name = $request->input('name');
        $mobile = $request->input('mobile');
        $baozi_id = $request->input('baozi');
        $num = $request->input('num');
        $address = $request->input('address');
        $menber = Menber::find($u_id);//销售实例
        if ($menber) {
            $customer = new Customer;
            $customer->name = $name;
            $customer->mobile = $mobile;
            $customer->contacts = $contacts;
            $customer->address = $address;
            $customer->source = '微信';
            $customer->user_id = $menber->user_id;
            $customer->save();

            //添加订单
            $periodical = Periodical::find($baozi_id);//报纸实例

            $input = new Input;
            $input->c_id = $customer->id;
            $input->user_id = $menber->user_id;
            $input->u_id = $menber->id;
            $input->menber_name = $menber->name;
            $input->d_id = $menber->d_id;
            $input->p_id = $periodical->id;
            $input->p_name = $periodical->id;
            $input->source = 1;
            $input->num = $num;
            $input->dis_per = $periodical->per;
            $input->p_money = $periodical->c_price != 0 ? $periodical->c_price : $periodical->price;
            $input->p_amount = ($num * $input->p_money);
            $input->pay_name = '无';
            $input->save();
            return redirect()->to('formm/s');
        }

    }
}