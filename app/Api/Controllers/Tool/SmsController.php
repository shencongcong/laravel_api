<?php

namespace App\Api\Controllers\Tool;

use App\Libraries\aliyunSmsController;
use App\Api\Controllers\ApiBaseController;
use Log;

class SmsController extends ApiBaseController
{
    /**
     * @param        $tel
     * @param string $tmp (模板id 默认不许要改变 )
     *  模板: 验证码5440（$code），您正在进行 登录($product)身份验证,打死不要告诉别人哦！
     * @param        $code
     * @param        $product
     * @return mixed|\SimpleXMLElement
     */
    public function sendSms($tel = '18817320310',$code='1234', $product='登录',$tmp =  "SMS_31085015")
    {
        $res = aliyunSmsController::sendMsg($tel,$code,$product,$tmp);
        // 短信发送不成功记录日志
        if($res !== 200){
            Log::info('SMS'.date('Y-m-d H:i:s').'||'.serialize($res));
        }
        return $res;
    }


    public function noticeSendSms($tel = '15921021906',$tmp =  "SMS_59995659")
    {
        $res = aliyunSmsController::noticeMsg($tel,$tmp);
        // 短信发送不成功记录日志
        if($res !== 200){
            Log::info('SMS'.date('Y-m-d H:i:s').'||'.serialize($res));
        }
        return $res;
    }

    /**
     *随机字符串
     */
    public function code()
    {
        return mt_rand(1000,9999);
    }
}