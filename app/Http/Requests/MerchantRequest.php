<?php

namespace App\Http\Requests;

use App\Traits\Admin\QiNiuFileUploadTrait;

class MerchantRequest extends Request
{

    use QiNiuFileUploadTrait;
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
            'merchant_name' => 'required',
            'shop_nums'     => 'required',
            'expire'        => 'required',
            'public_id'     => 'required',
        ];
    }

    public function messages()
    {
        return [
            'merchant_name.required' => '请输入商户名称',
            //'merchant_name.unique'   => '商户名称已存在',
            'shop_nums.required'     => '请输入门店数量',
            'expire.required'        => '请输入到期时间',
            'public_id.required'     => '请选择公众号'
        ];
    }
}
