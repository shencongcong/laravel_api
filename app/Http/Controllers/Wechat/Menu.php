<?php

namespace App\Http\Controllers\Wechat;

use EasyWeChat\Foundation\Application;
use App\Http\Controllers\Controller;

class Menu extends Controller
{
    public $appid;
    public $authorizer_refresh_token;

    /**
     * Menu constructor.
     * @param $appid
     * @param $authorizer_refresh_token
     */
    public function __construct($appid = 'wx456828ef5e9900e7', $authorizer_refresh_token = 'refreshtoken@@@fwcb5ouIX8mCHwUzFSLB_yfJTmFuhI8wgQs-JmKqJ8Q')
    {
        $this->appid = $appid;
        $this->authorizer_refresh_token = $authorizer_refresh_token;
    }

    public function getMenu()
    {
        //dd('1');
        $options = config('wechat');
        $app = new Application($options);
        $openPlatform = $app->open_platform;
        $apps = $openPlatform->createAuthorizerApplication($this->appid, $this->authorizer_refresh_token);
        $menu = $apps->menu;

        $res = $menu->all();
        return $res;

    }


}