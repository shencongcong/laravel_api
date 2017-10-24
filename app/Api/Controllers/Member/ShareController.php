<?php

namespace App\Api\Controllers\Member;

use App\Api\Controllers\ApiBaseController;
use Illuminate\Http\Request;
use DB;
use Log;

class ShareController extends ApiBaseController
{
    public function getShareLink(Request $request)
    {
        $merchant_id = $request->get('merchant_id');
        $public = DB::table('wr_merchant')
            ->join('wr_public', 'wr_merchant.public_id', '=', 'wr_public.id')
            ->where('wr_merchant.id', '=',$merchant_id)
            ->select('wr_public.appid','wr_public.authorizer_refresh_token')
            ->get();
        $appid = $public[0]->appid;
        $authorizer_refresh_token = $public[0]->authorizer_refresh_token;
        $qrCode = new \App\Http\Controllers\Wechat\qrCodeController($appid,$authorizer_refresh_token);
        return $qrCode->forever($merchant_id);
    }

    public function getShareInfo()
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $public_info = DB::table('wr_merchant')
            ->where(['id'=>$merchant_id])
            ->select('merchant_name','logo','introduce')
            ->get();
        $data['merchant_name'] = $public_info[0]->merchant_name;
        $data['merchant_introduce'] = $public_info[0]->introduce;
        $data['merchant_logo'] = $public_info[0]->logo;

        $public = DB::table('wr_merchant')
            ->join('wr_public', 'wr_merchant.public_id', '=', 'wr_public.id')
            ->where('wr_merchant.id', '=',$merchant_id)
            ->select('wr_public.appid','wr_public.authorizer_refresh_token')
            ->get();
        $appid = $public[0]->appid;
        $authorizer_refresh_token = $public[0]->authorizer_refresh_token;
        $qrCode = new \App\Http\Controllers\Wechat\qrCodeController($appid,$authorizer_refresh_token);
        $url  = $qrCode->foreverUrl($merchant_id);
        $data['share_link'] = config('constants.MEMBER_SHARE').'?img='.$url;
        return $this->successResponse(200,'成功',$data);
    }

}