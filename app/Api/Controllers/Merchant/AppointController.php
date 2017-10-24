<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:21
 */

namespace App\Api\Controllers\Merchant;

use App\Api\Controllers\ApiBaseController;
use App\Api\Transformer\AppointTransformer;
use Illuminate\Http\Request;
use App\Repositories\Contracts\AppointRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class AppointRankController
 * @package App\Api\Controllers
 */
class AppointController extends ApiBaseController
{

    private $appoint;

    protected $appointTransformer;

    /**
     * AppointRankController constructor.
     * @param AppointRankRepository $appointRankRepository
     * @param AppointRankTransformer $appointRankTransformer
     */
    public function __construct(AppointRepository $appointRepository, AppointTransformer $appointTransformer)
    {
        $this->appoint = $appointRepository;
        $this->appointTransformer = $appointTransformer;
    }

    /**
     * @post
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * $status:预约的状态，1：预约中  2：预约完成（到店）
     */
    public function index(Request $request)
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $status = $request->input('status');
        if (empty($status)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $reason = 0;    //0：正常 1：客户取消  2：门店取消
        $appoint = $this->appoint->index($merchant_id, $status, $reason);
        //return $appoint;
        if ($appoint) {
            return $this->successResponse(200, '成功', $this->appointTransformer->transformer($appoint));
        } else {
            return $this->errorResponse(204, '无内容');
        }
    }
    
    /**
     * @post
     * 根据店铺的id获取预约信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * $status:预约的状态，1：预约中  2：预约完成（到店）
     * $shop_id 店铺的id
     */
    public function byShopAppoint(Request $request)
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $shop_id = $request->input('shop_id');
        $status = $request->input('status');
        if (empty($status) || empty($shop_id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $reason = 0;    //0：正常 1：客户取消  2：门店取消
        $appoint = $this->appoint->byShopAppoint($merchant_id, $status, $reason, $shop_id);
        if ($appoint) {
            return $this->successResponse(200, '成功', $this->appointTransformer->transformer($appoint));
        } else {
            return $this->errorResponse(204, '暂无数据');
        }
    }
}

