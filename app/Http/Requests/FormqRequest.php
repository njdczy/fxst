<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/2
 * Time: 18:51
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class FormqRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'mobile' => 'required',
            'baozi' => 'required',
            'num' => 'required',
            'address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'contacts.required' => '请输入联系人',
            'name.required' => '请输入联系人',
            'mobile.required' => '请输入联系方式',
            'baozi.required' => '请选择报纸',
            'num.required' => '请输入数量',
            'address.required' => '请填写地址',

        ];
    }
}