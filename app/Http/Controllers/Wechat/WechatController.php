<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;
use Log;
use DB;

class WechatController extends Controller
{
    public function serve($appid)
    {
        $options = config('wechat');
        $app = new Application($options);
        $openPlatform = $app->open_platform;
        $authorizer_refresh_token_obj  = DB::table('wr_public')->where('appid',$appid)->select('authorizer_refresh_token')->get();
        $authorizer_refresh_token = $authorizer_refresh_token_obj[0]->authorizer_refresh_token;
        $apps = $openPlatform->createAuthorizerApplication($appid, $authorizer_refresh_token);
        $apps->server->setMessageHandler(function($message) use ($openPlatform,$appid,$apps){
            // 接入开放平台逻辑
            if($appid == 'wx570bc396a51b8ff8'){
                if ($message->Content == 'TESTCOMPONENT_MSG_TYPE_TEXT') {
                    return 'TESTCOMPONENT_MSG_TYPE_TEXT_callback';
                } elseif (strpos($message->Content, 'QUERY_AUTH_CODE') !== false) {
                    $query_auth_code = str_replace ( 'QUERY_AUTH_CODE:', '',$message->Content);
                    $param ['touser'] = $message->FromUserName;
                    $param ['msgtype'] = 'text';
                    $param ['text'] ['content'] = $query_auth_code . '_from_api';

                    $authorizer_access_token_obj = $openPlatform->getAuthorizationInfo($query_auth_code);

                    $authorizer_access_token = $authorizer_access_token_obj['authorization_info']['authorizer_access_token'];
                    Log::info('authorizer_access_token'.serialize($authorizer_access_token));
                    $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$authorizer_access_token;
                    post_data ( $url, $param );
                } elseif ($message->MsgType == 'event') {
                    return $message->Event . "from_callback";
                }
            }
            // 处理微信的业务逻辑
//            Log::info('ToUserName'.serialize($message->ToUserName));
            $public_token = $message->ToUserName;
            $public_name = DB::table('wr_public')->where('token',$public_token)->value('public_name');
//            Log::info('ToUserName'.serialize($public_name));
            switch ($message->MsgType) {
                case 'event':
                    if ($message->Event == 'subscribe') {
                        Log::info('subscribe');
                        $scene = substr($message->EventKey,8);;
                        $this->subsrcibe($message,$apps);
                        if(!empty($scene)){
                            $data['open_id'] = $openId = $message->FromUserName;
                            $res = DB::table('wr_member')->where(['open_id'=>$openId,'merchant_id'=>$scene])->first();
                            if(!$res){
                                $userInfo = $apps->user->get($openId);
                                $data['merchant_id'] = $scene;
                                $data['member_name'] = $userInfo->nickname;
                                $data['sex'] = $userInfo->sex;
                                $data['img']= $userInfo->headimgurl;
                                $data['created_at'] = time();
                                $id = DB::table('wr_member')->insertGetId($data);
                                return '欢迎关注'.$public_name.'，在线预约不用等待';
                            }
                            return '欢迎关注'.$public_name.'，在线预约不用等待';
                        }

                        return '欢迎关注'.$public_name.'，在线预约不用等待';
                    }
                    if ($message->Event == 'unsubscribe') {
                        $this->unsubscribe($message,$apps);
                    }
                    if ($message->Event == 'SCAN') {
                        $scene = $message->EventKey;
                        $this->subsrcibe($message,$apps);
                        if (!empty($scene)) {
                            $data['open_id'] = $openId = $message->FromUserName;
                            $res = DB::table('wr_member')->where(['open_id'=>$openId,'merchant_id'=>$scene])->first();
                            if(!$res){
                                $userInfo = $apps->user->get($openId);
                                $data['merchant_id'] = $scene;
                                $data['member_name'] = $userInfo->nickname;
                                $data['sex'] = $userInfo->sex;
                                $data['img']= $userInfo->headimgurl;
                                $data['created_at'] = time();
                                $id = DB::table('wr_member')->insertGetId($data);
                                return '欢迎关注'.$public_name.'，在线预约不用等待';
                            }

                            return '欢迎关注'.$public_name.'，在线预约不用等待';
                        }
                    }
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
                //return 'ni hao';
            }
        });

        return $apps->server->serve();
    }

    public function subsrcibe($message,$apps)
    {
        Log::info('wxuser');
        $openId = $message->FromUserName;
        $token = $message->ToUserName;
        $res1 = DB::table('wr_wuser')->where(['open_id'=>$openId,'token'=>$token])->first();
        if($res1){
            DB::table('wr_wuser')->where(['open_id'=>$openId,'token'=>$token])->update(['is_subscribe'=>1]);
        /*    $id = DB::table('wr_wuser')->where(['open_id'=>$openId,'token'=>$token])->select('id')->get();
            Log::info('ID'.serialize($id));
            return $id[0]->id;*/
        }else{
            // TODO 处理微信昵称中emoji 表情符号
            $userInfo = $apps->user->get($openId);
            Log::info('userInfo1'.serialize($userInfo));
            $data['nickname'] = $userInfo->nickname;
            $data['sex'] = $userInfo->sex;
            $data['language'] = $userInfo->language;
            $data['province'] = $userInfo->province;
            $data['city'] = $userInfo->city;
            $data['country'] = $userInfo->country;
            $data['headimgurl']= $userInfo->headimgurl;
            $data['language'] = $userInfo->language;
            $data['subscribe_time'] = $userInfo->subscribe_time;
            $data['remark'] = $userInfo->remark;
            $data['groupid'] = $userInfo->groupid;
            $data['is_subscribe'] = 1;
            $data['open_id'] = $openId;
            $data['token'] = $token;
            DB::table('wr_wuser')->insertGetId($data);

            //return '2';
        }
    }

    private function unsubscribe($message, $apps)
    {
        $openId = $message->FromUserName;
        $token = $message->ToUserName;
        DB::table('wr_wuser')->where(['open_id'=>$openId,'token'=>$token])->update(['is_subscribe'=>0]);
    }

}
