<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;
use Cache;

class qrCodeController extends Controller
{

    public $appid;
    public $authorizer_refresh_token;
    public $apps;
    public $qrcode;

    public function __construct($appid = 'wx456828ef5e9900e7',$authorizer_refresh_token ='refreshtoken@@@fwcb5ouIX8mCHwUzFSLB_yfJTmFuhI8wgQs-JmKqJ8Q')
    {
        $this->appid = $appid;
        $this->authorizer_refresh_token = $authorizer_refresh_token;
        $options = config('wechat');
        $app = new Application($options);
        $openPlatform = $app->open_platform;
        $this->apps = $openPlatform->createAuthorizerApplication($this->appid, $this->authorizer_refresh_token);
        $this->qrcode = $this->apps->qrcode;
    }


    /**
     * @get 生成场景值得永久二维码
     * @param string $sence
     * @param boolean $flag 是否强制刷新缓存 true：强制刷新
     * @return string
     */
    public function forever($sence = '41',$flag = true)
    {
        if(Cache::get('qrCodeController_forever'.$this->appid.$sence)&&!$flag){
            $url = Cache::get('qrCodeController_forever'.$this->appid.$sence);
            return redirect($url);
        }
        $result = $this->qrcode->forever($sence);
        $ticket = $result->ticket;
        $url = $this->apps->qrcode->url($ticket);
        Cache::put('qrCodeController_forever'.$this->appid.$sence,$url,config('constants.ONE_YEAR'));
        return redirect(config('constants.MEMBER_SHARE').'?img='.$url);
    }

    /**
     * @get 生成场景值得永久二维码
     * @param string $sence
     * @param boolean $flag 是否强制刷新缓存 true：强制刷新
     * @return string
     */
    public function foreverUrl($sence = '41',$flag = true)
    {
        if(Cache::get('qrCodeController_forever'.$this->appid.$sence)&&!$flag){
            $url = Cache::get('qrCodeController_forever'.$this->appid.$sence);
            return $url;
        }
        $result = $this->qrcode->forever($sence);
        $ticket = $result->ticket;
        $url = $this->apps->qrcode->url($ticket);
        Cache::put('qrCodeController_forever'.$this->appid.$sence,$url,config('constants.ONE_YEAR'));
        return $url;
    }

    /**
     * @get 生成带场景值对的临时二维码
     * @param string $sence
     * @param string $expire
     * @return string
     */
    public function temporary($sence = '1', $expire = '6 * 24 * 3600')
    {
        $result = $this->apps->qrcode->temporary($sence, $expire);
        $ticket = $result->ticket;

        $url = $this->apps->qrcode->url($ticket);
        return $url;
    }
}