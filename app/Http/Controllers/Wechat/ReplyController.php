<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;
use Log;

class ReplyController extends Controller
{

    public $appid;
    public $authorizer_refresh_token;
    public $apps;
    public $reply;

    public function __construct($appid='wxc3c47e69c7e71c65',$authorizer_refresh_token='refreshtoken@@@YPal9pg_f2LWCcxuepArB22jE6GabssMsMDvLJp4Qeo')
    {
        $this->appid = $appid;
        $this->authorizer_refresh_token = $authorizer_refresh_token;
        $options = config('wechat');
        $app = new Application($options);
        $openPlatform = $app->open_platform;
        $this->apps = $openPlatform->createAuthorizerApplication($this->appid, $this->authorizer_refresh_token);
        $this->reply = $this->apps->reply;
    }

    public function reply()
    {
        dd($this->reply->current());

    }
}