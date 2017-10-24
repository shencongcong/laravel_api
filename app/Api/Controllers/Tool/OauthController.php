<?php

namespace App\Api\Controllers\Tool;

use App\Api\Controllers\ApiBaseController;
use DB;
use Illuminate\Http\Request;
use Log;

class OauthController extends ApiBaseController
{

    //服务师注册
    public function waiterRegisterIndex(Request $request)
    {
        $merchant_id = $request->get('merchant_id');
        $callback = $request->get('callback');
        $domains = config('constants.APP_DOMAIN');
        $flags = false;
        foreach($domains as $domain){
            if(strpos($callback,$domain) !== false){
                $flags = true;
            }
        }
        if(!$flags){
            return $this->errorResponse(7001, '授权域名不合法');
        }
        session(['OauthController_waiterRegisterIndex_callback' => $callback,
            'OauthController_waiterRegisterIndex_merchant_id' => $merchant_id
        ]);
        //dd(session('OauthController_waiterRegisterIndex_callback'));
        $users = DB::table('wr_merchant')
            ->join('wr_public', 'wr_merchant.public_id', '=', 'wr_public.id')
            ->where('wr_merchant.id', '=',$merchant_id)
            ->select('wr_public.appid','wr_public.authorizer_refresh_token')
            ->get();
        $appid = $users[0]->appid;
        $authorizer_refresh_token = $users[0]->authorizer_refresh_token;
        $wrCallback = url('api/oauth/waiterRegisterBack');
        $ext = [
            'merchant_id' => $merchant_id,
            'callback' => $callback
        ];
        Log::info('infoss'.$merchant_id.$callback);
        $ext_str =   base64_encode(serialize($ext));
        $url = url('wechat/oauth/snsapiBase').'?appid='.$appid.'&authorizer_refresh_token='.$authorizer_refresh_token.'&wrCallback='.$wrCallback.'&ext='.$ext_str;

        return redirect($url);
    }

    // 服务师注册回调
    public function waiterRegisterBack(Request $request)
    {
        $open_id = $request->get('open_id');
        $img = $request->get('img');
        $nickname = $request->get('nickname');
        $ext = $request->get('ext');
        $ext_arr = unserialize(base64_decode($ext));
        $merchant_id = $ext_arr['merchant_id'];
        $callback = $ext_arr['callback'];
        // 签名
        $str = config('constants.SIGNATURES_KEY');
        $token = signature($open_id,$str,$merchant_id);
        return  redirect($callback.'?open_id='.$open_id.'&nickname='.$nickname.'&img='.$img.'&merchant_id='.$merchant_id.'&token='.$token);
    }

    // 登录
    public function loginIndex(Request $request)
    {
        $callback = $request->get('callback');
        $appid = $request->get('appid');
        Log::info('appid'.$appid);
        //$domain = $request->get('domain');
        //校验回调的域名是否合法
        $domains = config('constants.APP_DOMAIN');
        $flags = false;
        foreach($domains as $domain){
            if(strpos($callback,$domain) !== false){
                $flags = true;
            }
        }
        if(!$flags){
            return $this->errorResponse(7001, '授权域名不合法');
        }
        try{
            $authorizer_refresh_token_obj = DB::table('wr_public')->where('appid',$appid)->select('authorizer_refresh_token')->get();
            $authorizer_refresh_token = $authorizer_refresh_token_obj[0]->authorizer_refresh_token;
            $ext = ['callback' => $callback];
            $ext_str =   base64_encode(serialize($ext));
            $wrCallback = url('api/oauth/loginBack');
            $url = url('wechat/oauth/snsapiBase').'?appid='.$appid.'&authorizer_refresh_token='.$authorizer_refresh_token.'&wrCallback='.$wrCallback.'&ext='.$ext_str;
            return redirect($url);
        }catch (Exception $e){
            return $this->errorResponse(500, '服务器报错');
        }


    }

    //登录回调
    public function loginBack(Request $request)
    {
        $open_id = $request->get('open_id');
        $ext = $request->get('ext');
        $ext_arr = unserialize(base64_decode($ext));
        $callback = $ext_arr['callback'];
        return  redirect($callback.'?open_id='.$open_id);
    }


}