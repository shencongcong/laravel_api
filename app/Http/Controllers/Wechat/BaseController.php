<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;
use DB;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $appid;
    public $authorizer_refresh_token;
    public $apps;

    public function __construct(Request $request)
    {
        $this->appid = 'wx456828ef5e9900e7';
/*        $authorizer_refresh_token_obj  = DB::table('wr_public')->where('appid',$this->appid)->select('authorizer_refresh_token')->get();*/
        $this->authorizer_refresh_token = 'refreshtoken@@@fwcb5ouIX8mCHwUzFSLB_yfJTmFuhI8wgQs-JmKqJ8Q';
        $options = config('wechat');
        $app = new Application($options);
        $openPlatform = $app->open_platform;
        $this->apps = $openPlatform->createAuthorizerApplication($this->appid, $this->authorizer_refresh_token);
    }
}