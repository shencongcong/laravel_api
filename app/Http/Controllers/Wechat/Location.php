<?php

namespace App\Http\Controllers\Wechat;

use EasyWeChat\Foundation\Application;
use App\Http\Controllers\Controller;

class Location extends Controller
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

    public function index()
    {
        $options = config('wechat');
        $app = new Application($options);
        $openPlatform = $app->open_platform;
        $apps = $openPlatform->createAuthorizerApplication($this->appid, $this->authorizer_refresh_token);
        $server = $apps->server;
        $server->setMessageHandler(function ($message) {
            switch ($message->MsgType) {
                case 'event':
                    return '收到事件消息';
                    break;
                case 'text':
                    return '收到文字消息';
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
            // ...
        });
        $message = $server->getMessage();
        dd($message);
    }
}