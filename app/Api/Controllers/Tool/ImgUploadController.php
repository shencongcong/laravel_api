<?php

namespace App\Api\Controllers\Tool;

use App\Api\Controllers\ApiBaseController;
use Illuminate\Http\Request;
use App\Traits\Admin\QiNiuFileUploadTrait;

class ImgUploadController extends ApiBaseController
{
    use QiNiuFileUploadTrait;

    public function index(Request $request)
    {
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filePath = $this->upload($file);
            if ($filePath) {
                return $this->successResponse(200, '成功', ['img'=>$filePath]);
            } else {
                return $this->errorResponse(500, '失败');
            }
        }
    }
}