<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:21
 */

namespace App\Api\Controllers\Member;

use App\Api\Controllers\ApiBaseController;
use App\Api\Transformer\AppointTransformer;
use Illuminate\Http\Request;
use App\Repositories\Contracts\AppointRepository;
use Illuminate\Support\Facades\DB;
use App\Jobs\AppointNotice;
use Illuminate\Support\Facades\Log;

/**
 * Class MyAppointController
 * @package App\Api\Controllers
 */
class MyAppointController extends ApiBaseController
{
    private $appoint;
    protected $appointTransformer;

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
        $member_id = $this->getMesByToken()['id'];
        $shop_id = $this->getMesByToken()['shop_id'];
        $status = intval($request->input('status'));
        if (empty($status)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $reason = 0;    //0：正常 1：客户取消  2：门店取消
        $appoint = $this->appoint->memberIndex($member_id, $shop_id, $status, $reason);
        if ($appoint) {
            if ($status == 1) {
                //预约中
                return $this->successResponse(200, '成功', $this->appointTransformer->memberTransformer($appoint));
            } elseif ($status == 2) {
                //预约完成
                foreach ($appoint as $k=>&$v){
                    if($v['is_comment'] == 0){
                        //---
                        $v['comment'] = array(
                            'waiter_grade' =>5,
                            'punctual_id' =>17,    //守时标签id
                            'stance_id' =>11,      //态度标签id
                            'art_id' =>14,         //技能标签id
                        );
                        $v['is_comment'] = (bool)$v['is_comment'];

                    }elseif($v['is_comment'] == 1){
                        $comment = DB::table('wr_waiter_comment')
                            ->where('appoint_id',$v['id'])
                            ->where('deleted_at',null)
                            ->select('waiter_grade','punctual_id','stance_id','art_id')
                            ->first();
                        $v['comment'] = array(
                            'waiter_grade' =>$comment->waiter_grade,
                            'punctual_id' =>$comment->punctual_id,  //守时标签id
                            'stance_id' =>$comment->stance_id,      //态度标签id
                            'art_id' =>$comment->art_id,            //技能标签id
                        );
                        $v['is_comment'] = (bool)$v['is_comment'];
                    }
                }
                return $this->successResponse(200, '成功', $this->appointTransformer->memberCompletedTransformer($appoint));
            }
        } else {
            return $this->successResponse(204, '数据为空');
        }
    }

    /**
     * @POST
     * 客户取消预约 0：正常 1：客户取消  2：门店取消
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
        $appoint_id = DB::table('wr_appoint')
            ->where('id', $arr['id'])
            ->value('appoint_id');
        $cancel = array('reason' => $arr['reason']);
        $res = $this->appoint->cancelUpdate($appoint_id, $cancel);
        if ($res) {
            //取消预约通知服务师
            $appoint_list = $this->appoint->appointById($arr['id']);
            $member_arr = (array)DB::table('wr_member')
                ->where('id', $appoint_list['member_id'])
                ->where('deleted_at', NULL)
                ->select('member_name', 'open_id')
                ->first();
            $member_name = $member_arr['member_name'];
            $time_date = $appoint_list['time_date'];
            $time_hour_text = date('H:i', $appoint_list['time_str']);
            $goods_two_text = DB::table('wr_goods_cate')
                ->where('id', $appoint_list['goods_id'])
                ->value('goods_name');
            $reason = '客户取消';

            $wx_waiter_open_id = DB::table('wr_waiter')
                ->where('id', $appoint_list['waiter_id'])
                ->value('open_id');
            $template_type = 'NOTICE_CANCEL';
            if ($wx_waiter_open_id) {
                $data = appoint_cancel_notice_hair($member_name, $time_date, $time_hour_text, $goods_two_text, $reason);
                $url = '';
                $job = (new AppointNotice($merchant_id, $wx_waiter_open_id, $template_type, $data, $url));
                $this->dispatch($job);
            } else {
                Log::info('会员取消预约--服务师不存在');
            }
            // TODO 取消预约通知会员消息
            $shop_name = DB::table('wr_shop')
                ->where('id', $appoint_list['shop_id'])
                ->value('shop_name');
            if ($member_arr) {
                $data1 = appoint_cancel_notice_member($member_name, $time_date, $time_hour_text, $goods_two_text, $reason, $shop_name);
                $wx_member_open_id = $member_arr['open_id'];
                $url1 = '';
                $job1 = (new AppointNotice($merchant_id, $wx_member_open_id, $template_type, $data1, $url1));
                $this->dispatch($job1);
            } else {
                Log::info('会员取消预约--会员不存在');
            }
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

