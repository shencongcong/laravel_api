<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use Log;

class JsSdkController extends Controller
{
    public $appid;
    public $authorizer_refresh_token;
    public $apps;
    public $js;

    public function __construct($appid = 'wx456828ef5e9900e7' ,$authorizer_refresh_token = 'refreshtoken@@@fwcb5ouIX8mCHwUzFSLB_yfJTmFuhI8wgQs-JmKqJ8Q')
    {
        $this->appid = $appid;
        $this->authorizer_refresh_token = $authorizer_refresh_token;
        $options = config('wechat');
        $app = new Application($options);
        $openPlatform = $app->open_platform;
        $this->apps = $openPlatform->createAuthorizerApplication($this->appid, $this->authorizer_refresh_token);
        $this->js = $this->apps->js;
    }

    public function getLocation($url = 'https://wr2.weerun.com/test.html')
    {
        $this->js->setUrl($url);
        return  $this->js->config(array('onMenuShareQQ', 'onMenuShareWeibo','getLocation','onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQZone'),false,$beta = false, $json = true);
    }

}