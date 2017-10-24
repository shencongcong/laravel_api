<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:21
 */

namespace App\Api\Controllers\Waiter;

use App\Api\Controllers\ApiBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 服务师调休
 * Class WaiterRestRankController
 * @package App\Api\Controllers\Waiter
 */
class WaiterRestController extends ApiBaseController
{
    /**
     * 调休添加
     * @POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $start_time = $this->dealStr($request->input('start_time'));
        $end_time = $this->dealStr($request->input('end_time'));
        $remark = $this->dealStr($request->input('remark'));
        $waiter_id = $this->getMesByToken()['id'];
        if (empty($start_time) || empty($end_time)) {
            return $this->errorResponse(405, '缺少必要的参数');
        }
        $time = time();
        if ($time > $start_time + 60 || $end_time <= $start_time) {
            return $this->errorResponse(1000, '时间区间错误');
        }
        //查看提交的时间区间是否在已经调休的区间
        $rest = DB::table('wr_waiter_rest')
            ->where('waiter_id', $waiter_id)
            ->where('end_time', '>=', $time)
            ->get();
        if ($rest) {
            $rest_arr = $rest;
            foreach ($rest_arr as $k => $v) {
                $v = (array)$v;
                if ($end_time >= $v['start_time'] && $start_time < $v['end_time']) {
                    return $this->errorResponse(1000, '时间区间错误');
                }
            }
        }
        //调休的时间区间
        $time_arr = array($start_time,$end_time);
        //查看该区间内是否有预约
        $appoint_num = DB::table('wr_appoint')
            ->where('waiter_id',$waiter_id)
            ->where('status',1)
            ->where('reason',0)
            ->where('deleted_at',NULL)
            ->whereBetween('time_str',$time_arr)
            ->count();
        if($appoint_num>0){
            return $this->errorResponse(5001, '该时间区间存在预约，是否确定调休');
        }
        $attr['start_time'] = $start_time;
        $attr['end_time'] = $end_time;
        $attr['remark'] = $remark;
        $attr['waiter_id'] = $waiter_id;

        $res1 = DB::table('wr_waiter_rest')->insert($attr);
        if ($res1) {
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(406, '失败');
        }
    }

    /**
     * 存在预约的情况下，提交调休
     * POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateHaveAppoint(Request $request)
    {
        $start_time = $this->dealStr($request->input('start_time'));
        $end_time = $this->dealStr($request->input('end_time'));
        $remark = $this->dealStr($request->input('remark'));
        $waiter_id = $this->getMesByToken()['id'];

        $attr['start_time'] = $start_time;
        $attr['end_time'] = $end_time;
        $attr['remark'] = $remark;
        $attr['waiter_id'] = $waiter_id;

        $res1 = DB::table('wr_waiter_rest')->insert($attr);
        if ($res1) {
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(406, '失败');
        }
    }

    /**
     * 调休首页
     * @POST
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $time = time();
        $waiter_id = $this->getMesByToken()['id'];
        $rest = DB::table('wr_waiter_rest')
            ->where('waiter_id', $waiter_id)
            ->where('end_time', '>', $time)
            ->get();
        if ($rest) {
            $rest_arr = (array)$rest;
            foreach ($rest_arr as $k => $v) {
                $v = (array)$v;
                $start_time = $v['start_time'];
                $end_time = $v['end_time'];
                $start_day = date('Y/m/d', $start_time);
                $end_day = date('Y/m/d', $end_time);
                $dif_day = intval(round((strtotime($end_day) - strtotime($start_day)) / 86400));
                if ($dif_day == 0) {
                    $attr[$k]['date'] = $start_day;
                    $attr[$k]['date_time'] = date('Y/m/d H:i', $start_time) . '--' . date('Y/m/d H:i', $end_time);
                    $attr[$k]['title'] = $v['remark'];
                    $attr[$k]['id'] = $v['id'];
                } else {
                    for ($i = 0; $i <= $dif_day; $i++) {
                        $attr[(strtotime($start_day) + $i * 86400 + $k)]['date'] = date('Y/m/d', (strtotime($start_day) + $i * 86400));
                        $attr[(strtotime($start_day) + $i * 86400 + $k)]['date_time'] = date('Y/m/d H:i', $start_time) . '--' . date('Y/m/d H:i', $end_time);
                        $attr[(strtotime($start_day) + $i * 86400 + $k)]['title'] = $v['remark'];
                        $attr[(strtotime($start_day) + $i * 86400 + $k)]['id'] = $v['id'];
                    }
                }
            }
            $attr = array_merge($attr);
            return $this->successResponse(200, '成功', $attr);
        } else {
            return $this->errorResponse(204, '暂无数据');
        }
    }

    /**
     * 调休管理
     * @DELETE
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $rest_id = $this->dealStr($request->input('id'));
        $res = DB::table('wr_waiter_rest')
            ->where('id', $rest_id)
            ->delete();
        if ($res) {
            return $this->successResponse(200, '删除成功');
        } else {
            return $this->errorResponse(406, '删除失败');
        }
    }


    /**
     * 服务师是否开启预约
     * @POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function openAppoint(Request $request)
    {
        $waiter_id = $this->getMesByToken()['id'];
        $status = $this->dealStr($request->input('status'));
        try {
            $res = DB::table('wr_waiter')
                ->where('id', $waiter_id)
                ->update(array('open_appoint' => $status));
            if ($res == 1 || $res == 0) {
                return $this->successResponse(200, '成功');
            } else {
                return $this->errorResponse(406, '失败');
            }
        } catch (\Exception $e) {
            return $this->errorResponse(406, '数据库异常');
        }

    }

    /**
     * 返回可否预约的状态
     * @GET
     * @return \Illuminate\Http\JsonResponse
     */
    public function openAppointStatus()
    {
        $waiter_id = $this->getMesByToken()['id'];
        $status = DB::table('wr_waiter')
            ->where('id', $waiter_id)
            ->value('open_appoint');
        return $this->successResponse(200, '成功', (bool)$status);
    }


}

