<?php

namespace App\Libraries;

    define('ALIYUNSMS_ROOT', dirname(__FILE__) . '/');
    require(ALIYUNSMS_ROOT . 'aliyunSms/aliyun-php-sdk-core/Config.php');
    use Sms\Request\V20160927 as Sms;

class aliyunSmsController{
    public static function sendMsg($tel,$code,$product,$template_id)
    {
        $iClientProfile = \DefaultProfile::getProfile("cn-hangzhou", "", "");
        $client = new \DefaultAcsClient($iClientProfile);
        $request = new Sms\SingleSendSmsRequest();

        $request->setSignName("");/*签名名称*/
        //"SMS_31085014"
        $request->setTemplateCode($template_id);/*模板code*/
        $request->setRecNum($tel);/*目标手机号*/
        //$request->setParamString("{\"customer\":\".$code.\"}");
        $request->setParamString("{\"code\":\" $code \",\"product\":\" $product \"}");
        //  $request->setParamString("{'customer':'scc'}");/*模板变量，数字一定要转换为字符串*/
        try {
            $response = $client->getAcsResponse($request);
            //dump($response->status_code);
            return $response->status_code;
        }
        catch (ClientException  $e) {
            //return $e->getErrorMessage();
            return 404;
        }
        catch (ServerException  $e) {
            return 404;
            //return $e->getErrorMessage();
        }
    }

    public static function noticeMsg($tel,$template_id)
    {
        $iClientProfile = \DefaultProfile::getProfile("cn-hangzhou", "", "");
        $client = new \DefaultAcsClient($iClientProfile);
        $request = new Sms\SingleSendSmsRequest();

        $request->setSignName("");/*签名名称*/
        //"SMS_31085014"
        $request->setTemplateCode($template_id);/*模板code*/
        $request->setRecNum($tel);/*目标手机号*/
        //$request->setParamString();
       // $request->setParamString("{\"code\":\" $code \",\"product\":\" $product \"}");
          $request->setParamString("{'customer':'scc'}");/*模板变量，数字一定要转换为字符串*/
        try {
            $response = $client->getAcsResponse($request);
            return $response;
            //dump($response);exit;
        }
        catch (ClientException  $e) {
            return 404;
            //return $e->getErrorMessage();
        }
        catch (ServerException  $e) {
            return 404;
            //return $e->getErrorMessage();
        }
    }
}