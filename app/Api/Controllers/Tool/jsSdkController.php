<?php

namespace App\Api\Controllers\Tool;

use App\Api\Controllers\ApiBaseController;
use DB;
use Illuminate\Http\Request;
use Log;

class jsSdkController extends ApiBaseController
{
    public function getLocation(Request $request)
    {
        try{
            $url = $request->get('url');
            $appid = $request->get('appid');

            $authorizer_refresh_token_obj = DB::table('wr_public')->where('appid',$appid)->select('authorizer_refresh_token')->get();
            Log::info('$authorizer_refresh_token_obj'.serialize($authorizer_refresh_token_obj));
            $authorizer_refresh_token = $authorizer_refresh_token_obj[0]->authorizer_refresh_token;
            $js = new \App\Http\Controllers\Wechat\JsSdkController($appid,$authorizer_refresh_token);
            return $js->getLocation($url);
        }catch (\Exception $e){
            Log::info('jssdk param error');
        }

    }
}