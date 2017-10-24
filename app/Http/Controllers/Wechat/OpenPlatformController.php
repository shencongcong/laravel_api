<?php

namespace App\Http\Controllers\Wechat;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat\OpenPlatform\Guard;
use Log;
use DB;

class OpenPlatformController extends Controller
{

    public function index()
    {
        $options = config('wechat');
        $app = new Application($options);
        $openPlatform = $app->open_platform;
        $server = $openPlatform->server;
        $server->setMessageHandler(function($event) use ($openPlatform) {
            // 事件类型常量定义在 \EasyWeChat\OpenPlatform\Guard 类里
            switch ($event->InfoType) {
                case Guard::EVENT_AUTHORIZED: // 授权成功
                    $authInfo = $openPlatform->getAuthorizationInfo($event->AuthorizationCode);
                    $publicInfo = $openPlatform->getAuthorizerInfo($authInfo['authorization_info']['authorizer_appid']);
                    $map ['token'] = $data ['token'] = $publicInfo ['authorizer_info'] ['user_name'];
                    $data ['public_name'] = $publicInfo ['authorizer_info'] ['nick_name'];
                    $data ['appid'] = $publicInfo ['authorization_info'] ['authorizer_appid'];
                    $data ['wechat'] = $publicInfo ['authorizer_info'] ['alias'];
                    $data ['is_bind'] = 1;
                    $data ['created_at'] = $data['updated_at'] = time();
                    $data ['encodingaeskey'] = 'DfEqNBRvzbg8MJdRQCSGyaMp6iLcGOldKFT0r8I6Tnp';
                    $data ['authorizer_refresh_token'] = $authInfo ['authorization_info'] ['authorizer_refresh_token'];
                    $public = DB::table('wr_public')->where('token','=',$map ['token'])->get();
                    if(!$public){
                        $res = DB::table('wr_public')->insert($data);
                    }else{
                        $res = Db::table('wr_public')->where('token', $map ['token'])->update($data);
                    }
                    break;
                case Guard::EVENT_UPDATE_AUTHORIZED: // 更新授权
                    break;
                case Guard::EVENT_UNAUTHORIZED: // 授权取消
                    $appid =    $event->AuthorizerAppid;
                    $res = DB::table('wr_public')->where('appid',$appid)->update(['is_bind'=>0]);
                    break;
            }
        });
        $response = $server->serve();
        return $response;
    }

    public function callBack()
    {
        return redirect(url('admin/public'));
    }
}
