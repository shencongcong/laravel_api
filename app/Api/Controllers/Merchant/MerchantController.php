<?php

namespace App\Api\Controllers\Merchant;

use App\Api\Controllers\ApiBaseController;
use App\Api\Transformer\MerchantTransformer;
use Illuminate\Http\Request;
use App\Repositories\Contracts\MerchantRepository;
use App\Api\Controllers\Tool\QrCodesController;
use Illuminate\Support\Facades\Log;
use Cache;
class MerchantController extends ApiBaseController
{
    private $merchant;
    private $merchantTransformer;

    public function __construct(MerchantRepository $merchantRepository,MerchantTransformer $merchantTransformer)
    {
        //$this->middleware('MerchantPermission:merchant');
        $this->merchant = $merchantRepository;
        $this->merchantTransformer = $merchantTransformer;
    }
    
    /*
     * 获取所有商户信息
     * */
    public function getAllMerchant()
    {
        $merchant = $this->merchant->getAllI();
        return $this->successResponse(200,'成功',$this->merchantTransformer->transformer($merchant));
    }


    /**
     * 商户推广二维码
     * @GET
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function merchantQrCode(Request $request )
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $qr = new QrCodesController();
        $url = config('constants.MEMBER_REGISTER')."?merchant_id=".$merchant_id;
        $qr_code =  $qr->createThreeSize($url);
        if($qr_code){
            $arr = array('code'=>$qr_code);
            return $this->successResponse(200,'成功',$arr);
        }else{
            Log::info('商户推广二维码获取失败---'.$qr_code);
            return $this->errorResponse(406,'获取失败');
        }
    }
}