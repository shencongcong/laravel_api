<?php

namespace App\Api\Controllers\Merchant;

use App\Api\Controllers\ApiBaseController;
use Illuminate\Http\Request;
use DB;

class SpreadController extends ApiBaseController
{
    public function code(Request $request)
    {
        $merchant_id = $request->get('merchant_id');
        $public_info = DB::table('wr_merchant')
            ->join('wr_public', 'wr_merchant.public_id', '=', 'wr_public.id')
            ->where('wr_merchant.id', '=',$merchant_id)
            ->select('wr_public.appid','wr_public.authorizer_refresh_token')
            ->get();
        $appid = $public_info[0]->appid;
        $authorizer_refresh_token = $public_info[0]->authorizer_refresh_token;
        $qrCode = new \App\Http\Controllers\Wechat\QrCodeController($appid,$authorizer_refresh_token);
        return $qrCode->forever($merchant_id);
    }
}