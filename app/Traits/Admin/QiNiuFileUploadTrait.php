<?php

namespace App\Traits\Admin;

use zgldh\QiniuStorage\QiniuStorage;

trait QiNiuFileUploadTrait
{
    public function upload($file)
    {
        $filePath = '';
        $disk = QiniuStorage::disk('qiniu');
        $fileName = md5($file->getClientOriginalName().time().rand()).'.'.$file->getClientOriginalExtension();
        $bool = $disk->put('wr2/'.date("Y-m-d").$fileName,file_get_contents($file->getRealPath()));
        if ($bool) {
            $filePath = $disk->downloadUrl('wr2/'.date("Y-m-d").$fileName,'https');
        }
        return $filePath;
    }
}