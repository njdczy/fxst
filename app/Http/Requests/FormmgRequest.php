<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormmgRequest extends FormRequest
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
            'mobile' => 'required|number',
            'baozi' => 'required',
            'num' => 'required',
            'address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '请输入联系人',
            'mobile.required' => '请输入联系方式',
            'baozi.required' => '请选择报纸',
            'num.required' => '请输入数量',
            'address.required' => '请填写地址',

        ];
    }
}
