<?php

namespace App\Http\Requests;


class MerchantAdminRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'nickname'   => 'required',
//            'admin_password'=>'required',
            'admin_tel' => 'required',
            'merchant_id'  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nickname.required'   => '请输入用户名',
            // 'admin_password.required' => '请输入用户密码',
            'admin_tel.required' => '请输入手机号',
            'merchant_id.required'  => '请选择商户号'
        ];
    }
}
