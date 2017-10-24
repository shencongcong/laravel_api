<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:21
 */

namespace App\Api\Controllers\Waiter;

use App\Api\Controllers\ApiBaseController;
use App\Api\Transformer\AppointRankTransformer;
use Illuminate\Http\Request;
use App\Repositories\Contracts\AppointRankRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class AppointRankController
 * @package App\Api\Controllers
 */
class AppointRankController extends ApiBaseController
{
    /**
     * @var AppointRankRepository
     */
    private $rank;
    /**
     * @var AppointRankTransformer
     */
    protected $rankTransformer;

    public function __construct(AppointRankRepository $appointRankRepository, AppointRankTransformer $appointRankTransformer)
    {
        $this->rank = $appointRankRepository;
        $this->rankTransformer = $appointRankTransformer;
    }

    /**
     * 预约统计首页
     * @get
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $waiter_id = $this->getMesByToken()['id'];
        //今天的预约量
        $today = date('Y-m-d');
        $today_appoint = $this->rank->waiterAppointByDay($waiter_id, $today);
        //昨天的预约量
        $yesterday = date("Y-m-d", strtotime("-1 day"));
        $yes_appoint = $this->rank->waiterAppointByDay($waiter_id, $yesterday);
        if ($today_appoint > $yes_appoint) {
            $day_add = '+' . ($today_appoint - $yes_appoint);
            $day_status = true;
        } elseif ($today_appoint < $yes_appoint) {
            $day_add = '-' . ($yes_appoint - $today_appoint);
            $day_status = false;
        } else {
            $day_add = '+' . ($today_appoint - $yes_appoint);
            $day_status = true;
        }

        //本周的预约量
        $week_start = mktime(0, 0, 0, date("m"), date("d") - date("w") + 1, date("Y"));
        $week_end = mktime(23, 59, 59, date("m"), date("d") - date("w") + 7, date("Y"));
        $week_arr = array($week_start, $week_end);
        $now_week_appoint = $this->rank->waiterAppointByDayInterval($waiter_id, $week_arr);
        //上周的预约量
        $last_week_start = mktime(0, 0, 0, date("m"), date("d") - date("w") + 1 - 7, date("Y"));
        $last_week_end = mktime(23, 59, 59, date("m"), date("d") - date("w") + 7 - 7, date("Y"));
        $last_week_arr = array($last_week_start, $last_week_end);
        $last_week_appoint = $this->rank->waiterAppointByDayInterval($waiter_id, $last_week_arr);
        if ($now_week_appoint > $last_week_appoint) {
            $week_add = '+' . ($now_week_appoint - $last_week_appoint);
            $week_status = true;
        } elseif ($now_week_appoint < $last_week_appoint) {
            $week_add = '-' . ($yes_appoint - $today_appoint);
            $week_status = false;
        } else {
            $week_add = '+' . ($now_week_appoint - $last_week_appoint);
            $week_status = true;
        }
        //本月的预约量
        $mouth_start = mktime(0, 0, 0, date("m"), 1, date("Y"));
        $mouth_end = mktime(23, 59, 59, date("m"), date("t"), date("Y"));
        $mouth_arr = array($mouth_start, $mouth_end);
        $now_mouth_appoint = $this->rank->waiterAppointByDayInterval($waiter_id, $mouth_arr);
        //上月的预约量
        $last_mouth_start = mktime(0, 0, 0, date("m") - 1, 1, date("Y"));
        $last_mouth_end = mktime(23, 59, 59, date("m"), 0, date("Y"));
        $last_mouth_arr = array($last_mouth_start, $last_mouth_end);
        $last_mouth_appoint = $this->rank->waiterAppointByDayInterval($waiter_id, $last_mouth_arr);
        if ($now_mouth_appoint > $last_mouth_appoint) {
            $mouth_add = '+' . ($now_mouth_appoint - $last_mouth_appoint);
            $mouth_status = true;
        } elseif ($now_mouth_appoint < $last_mouth_appoint) {
            $mouth_add = '-' . ($now_mouth_appoint - $last_mouth_appoint);
            $mouth_status = false;
        } else {
            $mouth_add = '+' . ($now_mouth_appoint - $last_mouth_appoint);
            $mouth_status = true;
        }
        $attr = array(
            array('appoint' => $today_appoint, 'num' => $day_add, 'add' => $day_status),
            array('appoint' => $now_week_appoint, 'num' => $week_add, 'add' => $week_status),
            array('appoint' => $now_mouth_appoint, 'num' => $mouth_add, 'add' => $mouth_status),
        );
        return $this->successResponse(200, '成功', $attr);
    }

    /**
     * 根据店铺id 展示 预约统计首页
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexByShopId(Request $request)
    {
        $shop_id = $this->dealStr($request->input('shop_id'));
        if(empty($shop_id)){
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $waiter_id = $this->getMesByToken()['id'];
        //今天的预约量
        $today = date('Y-m-d');
        $today_appoint = $this->rank->waiterAppointByDayByShop($waiter_id, $shop_id, $today);
        //昨天的预约量
        $yesterday = date("Y-m-d", strtotime("-1 day"));
        $yes_appoint = $this->rank->waiterAppointByDayByShop($waiter_id, $shop_id, $yesterday);
        if ($today_appoint > $yes_appoint) {
            $day_add = '+' . ($today_appoint - $yes_appoint);
            $day_status = true;
        } elseif ($today_appoint < $yes_appoint) {
            $day_add = '-' . ($yes_appoint - $today_appoint);
            $day_status = false;
        } else {
            $day_add = '+' . ($today_appoint - $yes_appoint);
            $day_status = true;
        }

        //本周的预约量
        $week_start = mktime(0, 0, 0, date("m"), date("d") - date("w") + 1, date("Y"));
        $week_end = mktime(23, 59, 59, date("m"), date("d") - date("w") + 7, date("Y"));
        $week_arr = array($week_start, $week_end);
        $now_week_appoint = $this->rank->waiterAppointByDayIntervalByShop($waiter_id, $shop_id, $week_arr);
        //上周的预约量
        $last_week_start = mktime(0, 0, 0, date("m"), date("d") - date("w") + 1 - 7, date("Y"));
        $last_week_end = mktime(23, 59, 59, date("m"), date("d") - date("w") + 7 - 7, date("Y"));
        $last_week_arr = array($last_week_start, $last_week_end);
        $last_week_appoint = $this->rank->waiterAppointByDayIntervalByShop($waiter_id, $shop_id, $last_week_arr);
        if ($now_week_appoint > $last_week_appoint) {
            $week_add = '+' . ($now_week_appoint - $last_week_appoint);
            $week_status = true;
        } elseif ($now_week_appoint < $last_week_appoint) {
            $week_add = '-' . ($yes_appoint - $today_appoint);
            $week_status = false;
        } else {
            $week_add = '+' . ($now_week_appoint - $last_week_appoint);
            $week_status = true;
        }
        //本月的预约量
        $mouth_start = mktime(0, 0, 0, date("m"), 1, date("Y"));
        $mouth_end = mktime(23, 59, 59, date("m"), date("t"), date("Y"));
        $mouth_arr = array($mouth_start, $mouth_end);
        $now_mouth_appoint = $this->rank->waiterAppointByDayIntervalByShop($waiter_id, $shop_id, $mouth_arr);
        //上月的预约量
        $last_mouth_start = mktime(0, 0, 0, date("m") - 1, 1, date("Y"));
        $last_mouth_end = mktime(23, 59, 59, date("m"), 0, date("Y"));
        $last_mouth_arr = array($last_mouth_start, $last_mouth_end);
        $last_mouth_appoint = $this->rank->waiterAppointByDayIntervalByShop($waiter_id, $shop_id, $last_mouth_arr);
        if ($now_mouth_appoint > $last_mouth_appoint) {
            $mouth_add = '+' . ($now_mouth_appoint - $last_mouth_appoint);
            $mouth_status = true;
        } elseif ($now_mouth_appoint < $last_mouth_appoint) {
            $mouth_add = '-' . ($now_mouth_appoint - $last_mouth_appoint);
            $mouth_status = false;
        } else {
            $mouth_add = '+' . ($now_mouth_appoint - $last_mouth_appoint);
            $mouth_status = true;
        }
        $attr = array(
            array('appoint' => $today_appoint, 'num' => $day_add, 'add' => $day_status),
            array('appoint' => $now_week_appoint, 'num' => $week_add, 'add' => $week_status),
            array('appoint' => $now_mouth_appoint, 'num' => $mouth_add, 'add' => $mouth_status),
        );
        return $this->successResponse(200, '成功', $attr);
    }



}