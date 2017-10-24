<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;
use Log;

class TemplatesController extends Controller
{
    public $appid;
    public $authorizer_refresh_token;
    public $apps;
    public $notice;

    public function __construct($appid ='wxc3c47e69c7e71c65',$authorizer_refresh_token = 'refreshtoken@@@fwcb5ouIX8mCHwUzFSLB_yfJTmFuhI8wgQs-JmKqJ8Q')
    {
        $this->appid = $appid;
        $this->authorizer_refresh_token = $authorizer_refresh_token;
        $options = config('wechat');
        $app = new Application($options);
        $openPlatform = $app->open_platform;
        $this->apps = $openPlatform->createAuthorizerApplication($this->appid, $this->authorizer_refresh_token);
        $this->notice = $this->apps->notice;
    }

    public  function send($userOpenId,$templateId,$data,$url)
    {
        $messageId = $this->notice->to($userOpenId)->uses($templateId)->andUrl($url)->data($data)->send();
        return $messageId;
    }

    public function getAllTemplates()
    {
        $allTemplates = $this->notice->getPrivateTemplates();
        dd($allTemplates);
    }
}