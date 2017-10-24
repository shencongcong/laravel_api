<?php

namespace App\Http\Requests;
use App\Traits\Admin\QiNiuFileUploadTrait;

class ApiMerchantAdminRequest extends Request
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
        return true;
    }

    public function messages()
    {
        return true;
    }
}
