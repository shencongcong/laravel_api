<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:21
 */

namespace App\Api\Controllers\Waiter;

use App\Api\Controllers\ApiBaseController;
use App\Api\Transformer\AppointTransformer;
use Illuminate\Http\Request;
use App\Repositories\Contracts\AppointRepository;
use Illuminate\Support\Facades\DB;
use App\Jobs\AppointNotice;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

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
        $waiter_id = $this->getMesByToken()['id'];
        $status = $request->input('status');
        if (empty($status)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $reason = 0;    //0：正常 1：客户取消  2：门店取消
        $appoint = $this->appoint->waiterIndex($waiter_id, $status, $reason);
        if ($appoint) {
            return $this->successResponse(200, '成功', $this->appointTransformer->waiterTransformer($appoint));
        } else {
            return $this->errorResponse(204, '数据为空');
        }
    }

    /**
     * @POST
     * 取消预约
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelAppoint(Request $request)
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $arr = $this->dealRequest($request->all());
        if (empty($arr) || empty($arr['id'] || empty($arr['reason']))) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $time = time();
        $cancel = array('reason' => $arr['reason']);
        $appoint_id = DB::table('wr_appoint')
            ->where('id', $arr['id'])
            ->value('appoint_id');
        $res = $this->appoint->cancelUpdate($appoint_id, $cancel);
        if ($res) {
            //通知客户取消预约
            $appoint_list = $this->appoint->appointById($arr['id']);
            if ($time <= $appoint_list['time_str']) {

                $time_date = $appoint_list['time_date'];
                $time_hour_text = date('H:i', $appoint_list['time_str']);
                $member_arr = (array)DB::table('wr_member')
                    ->where('id', $appoint_list['member_id'])
                    ->select('member_name', 'open_id')
                    ->first();
                if ($member_arr) {
                    $member_name = $member_arr['member_name'];
                    $wx_member_open_id = $member_arr['open_id'];
                    $goods_two_text = DB::table('wr_goods_cate')
                        ->where('id', $appoint_list['goods_id'])
                        ->value('goods_name');
                    $reason = '门店取消';
                    $shop_name = DB::table('wr_shop')
                        ->where('id', $appoint_list['shop_id'])
                        ->value('shop_name');
                    $template_type = 'NOTICE_CANCEL';
                    $url = '';
                    $data = appoint_cancel_notice_member($member_name, $time_date, $time_hour_text, $goods_two_text, $reason, $shop_name);
                    $job = (new AppointNotice($merchant_id, $wx_member_open_id, $template_type, $data, $url));
                    $this->dispatch($job);
                }
            }
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(406, '失败');
        }
    }

    /**
     * @POST
     * 确认到店
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirmShop(Request $request)
    {
        $arr = $this->dealRequest($request->all());
        if (empty($arr) || empty($arr['id'] || empty($arr['status']))) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $confirm = array('status' => $arr['status']);
        //return ($arr);
        $res = $this->appoint->confirmShop($arr['id'], $confirm);
        if ($res) {
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(406, '失败');
        }
    }

    /**
     * @DELETE
     * 预约删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $appoint_id = $this->dealRequest($request->only('id'));
        if (empty($appoint_id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $res = $this->appoint->destroy($appoint_id['id']);
        if ($res) {
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(404, '失败');
        }
    }
}

