<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use EasyWeChat\Foundation\Application;
use Log;

class OauthController extends Controller
{


    public $appid;
    public $authorizer_refresh_token;
    public $apps;

    public function __construct(Request $request)
    {
        $this->appid = $request->get('appid');
        $this->authorizer_refresh_token = $request->get('authorizer_refresh_token');
        $options = config('wechat');
        $app = new Application($options);
        $openPlatform = $app->open_platform;
        $this->apps = $openPlatform->createAuthorizerApplication($this->appid, $this->authorizer_refresh_token);
    }

    public function snsapiBase(Request $request)
    {
        $wrCallback = $request->get('wrCallback');
        $ext = $request->get('ext');
        session(['OauthController_construct_wrCallback' => $wrCallback,
                 'OauthController_construct_ext' => $ext,
        ]);
        $response = $this->apps->oauth->scopes(['snsapi_userinfo'])
            ->redirect();
        return $response;
    }

    public function callback()
    {
        $user = $this->apps->oauth->user();
        $openId = $user->getId();  // 对应微信的 OPENID
        $nickname = $user->getNickname(); // 对应微信的 nickname
        $img = $user->getAvatar(); // 头像网址
        $wrCallback = session('OauthController_construct_wrCallback');
        $ext = session('OauthController_construct_ext');
        //dd($wrCallback);
        return  redirect($wrCallback.'?open_id='.$openId.'&nickname='.$nickname.'&img='.$img.'&ext='.$ext);
    }
    
}