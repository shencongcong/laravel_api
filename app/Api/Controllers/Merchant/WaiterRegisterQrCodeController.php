<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:21
 */

namespace App\Api\Controllers\Merchant;

use App\Api\Controllers\ApiBaseController;
use Illuminate\Http\Request;
use App\Repositories\Contracts\AppointRepository;
use Illuminate\Support\Facades\DB;
use App\Api\Controllers\Tool\QrCodesController;
use Illuminate\Support\Facades\Log;

/**
 * Class AppointRankController
 * @package App\Api\Controllers
 */
class WaiterRegisterQrCodeController extends ApiBaseController
{
    private $appoint;

    /**
     * AppointRankController constructor.
     * @param AppointRankRepository $appointRankRepository
     * @param AppointRankTransformer $appointRankTransformer
     */
    public function __construct(AppointRepository $appointRepository)
    {
        $this->appoint = $appointRepository;
    }

    /**
     * 服务师注册二维码
     * @Get
     * @return \Illuminate\Http\JsonResponse
     */
    public function buildQrCode()
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $qr_code = new QrCodesController();
        $url = Config('constants.WAITER_REGISTER')."?merchant_id=".$merchant_id;
        $code = $qr_code->createThreeSize($url);
        if ($code) {
            $arr = array('code'=>$code);
            return $this->successResponse(200, '成功',$arr);
        } else {
            Log::info('服务师注册二维码获取失败---'.$code);
            return $this->errorResponse(406, '失败');
        }
    }

}

