<?php

namespace App\Api\Controllers\Tool;

use App\Api\Controllers\ApiBaseController;
use DB;
use Mockery\Exception;
use Log;

class TemplatesController extends ApiBaseController
{

    public static function send($merchant_id ='41',$openId='o9KRbwrHxbx-HENgY2zx-Zhki_64',$template ='NOTICE_MEMBER_OK',$data=[
        "first"  => "亲爱哒，您已预约成功！",
        "keyword1"   => "爱米小铺",
        "keyword2"  => "美甲",
        "keyword3"  => "2017-03-27",
        "keyword4"  => "18612267949",
        "remark" => "如需修改时间，请提前联系店主哦~",
    ],$url)
    {
        // 商户号-》获取appid 和 authorizer_refresh_token
        // 根据商户号获取公众号 appid -> 获取模板id
        try{
            $users = DB::table('wr_merchant')
                ->join('wr_public', 'wr_merchant.public_id', '=', 'wr_public.id')
                ->where('wr_merchant.id', '=',$merchant_id)
                ->select('wr_public.appid','wr_public.authorizer_refresh_token')
                ->get();
            $appid = $users[0]->appid;
            $authorizer_refresh_token = $users[0]->authorizer_refresh_token;
            $templates = new \App\Http\Controllers\Wechat\TemplatesController($appid,$authorizer_refresh_token);
            $templateId = config('constants.APPID')[$appid][$template];
            $res = $templates->send($openId,$templateId,$data,$url);
            return $res;
        }catch (Exception $e){
            Log::info('模板消息发送失败');
        }
    }
}