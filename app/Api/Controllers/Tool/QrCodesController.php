<?php

namespace App\Api\Controllers\Tool;

use App\Api\Controllers\ApiBaseController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Cache;

class QrCodesController extends ApiBaseController
{
    /**
     * @param string $url
     * @param string $size
     * @return string
     * TODO 暂时二维码放在本地服务器，后期将图片迁移到七牛云服务器
     */
    public function create($url = 'http://www.weerun.com',$size = '100')
    {
        $resources = Cache::get('QrCodesController_create_'.$url);
        if($resources&&@fopen( $resources, 'r' )){
            return $resources;
        }
        $pictureName = md5(uniqid(rand())).'.png';
        QrCode::format('png')->size($size)->generate($url,public_path('qrcodes/'.$pictureName ));
        Cache::put('QrCodesController_create_'.$url,config('constants.WEB_SITE') . '/qrcodes/' . $pictureName,config('constants.ONE_YEAR'));
        return config('constants.WEB_SITE') . '/qrcodes/' . $pictureName;
    }

    /**
     * 生成size为300的图片
     * @param string $url
     * @param string $size
     * @return string
     * TODO 暂时二维码放在本地服务器，后期将图片迁移到七牛云服务器
     */
    public function createThreeSize($url = 'http://www.weerun.com',$size = '300')
    {
        $resources = Cache::get('QrCodesController_create_'.$url.$size);
        if($resources&&@fopen( $resources, 'r' )){
            return $resources;
        }
        $pictureName = md5(uniqid(rand())).'.png';
        QrCode::format('png')->size($size)->generate($url,public_path('qrcodes/'.$pictureName ));
        Cache::put('QrCodesController_create_'.$url.$size,config('constants.WEB_SITE') . '/qrcodes/' . $pictureName,config('constants.ONE_YEAR'));
        return config('constants.WEB_SITE') . '/qrcodes/' . $pictureName;
    }
}