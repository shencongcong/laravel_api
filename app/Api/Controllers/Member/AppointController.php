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
use Cache;

/**
 * Class AppointController
 * @package App\Api\Controllers\Member
 */
class AppointController extends ApiBaseController
{
    /**
     * @var AppointRepository
     */
    private $appoint;
    /**
     * @var AppointTransformer
     */
    protected $appointTransformer;

    public function __construct(AppointRepository $appointRepository, AppointTransformer $appointTransformer)
    {
        $this->appoint = $appointRepository;
        $this->appointTransformer = $appointTransformer;
    }

    /**
     * @POST
     * 获取预约时间点
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAppointTime(Request $request)
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $member_id = $this->getMesByToken()['id'];
        $waiter_id = $request->input('waiter_id');
        $goods_id = $request->input('goods_id');
        $shop_id = $this->getMesByToken()['shop_id'];
        if (empty($waiter_id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        //预约次数限制
        $appoint_num = Cache::get((date('Y-m-d') . $member_id));
        if ($appoint_num >config('constants.CAN_APPOINT_NUM')){
            return $this->errorResponse(6001, '预约次数达到上限');
        }
        //获取服务师是否开启预约
        $open_appoint = DB::table('wr_waiter')
            ->where(['id' => $waiter_id, 'deleted_at' => null])
            ->value('open_appoint');
        //服务时长
        $sever_time = DB::table('wr_goods_cate')
            ->where('id', $goods_id)
            ->value('sever_time');
        //获取7天日期
        $now_time = time();
        for ($i = 0; $i <= 6; $i++) {
            $time_ymd[$i] = date("Y-m-d", $now_time + $i * 24 * 3600);
        }
        //获取预约的时间节点
        $appoint_str = array();
        foreach ($time_ymd as $k => $v) {
            if ($open_appoint == 1) {
                $use_time = array();
                $appoint_str[$k]['year'] = date('Y', strtotime($v));
                $appoint_str[$k]['day'] = date('m-d', strtotime($v));
                //根据产品服务时长获取被使用的时间点
                $appoint_str[$k]['sort'] = $this->_getTimeByShopOpenTime($shop_id, $v, $sever_time, $use_time, $open_appoint);
            } else {
                //查询服务师被占用的时间点
                $use_time = DB::table('wr_waiter_appoint_time')
                    ->where('waiter_id', $waiter_id)
                    ->where('shop_id', $shop_id)
                    ->where('merchant_id', $merchant_id)
                    ->where('status', 1)
                    ->where('time_date', $v)
                    ->orderBy('time_hour', 'asc')
                    ->pluck('time_hour');

                $appoint_str[$k]['year'] = date('Y', strtotime($v));
                $appoint_str[$k]['day'] = date('m-d', strtotime($v));
                //根据产品服务时长获取被使用的时间点
                $appoint_str[$k]['sort'] = $this->_getTimeByShopOpenTime($shop_id, $v, $sever_time, $use_time, $open_appoint);
            }
        }
        $appoint_str = array_merge($appoint_str);
        foreach ($appoint_str as $k => &$v) {
            foreach ($v['sort'] as $k1 => &$v1) {
                $v1['key'] = $k . '-' . $k1;
            }
        }
        if ($open_appoint == 0) {
            //获取服务师的调休时间
            $rest = DB::table('wr_waiter_rest')
                ->where('waiter_id', $waiter_id)
                ->where('end_time', '>=', $now_time)
                ->select('start_time', 'end_time')
                ->get();
            if ($rest) {
                foreach ($rest as $k => &$v) {
                    $v = (array)$v;
                    $end_time = $v['end_time'];
                    $start_time = $v['start_time'];
                    foreach ($appoint_str as $k1 => &$v1) {
                        //$year = $v1['year'];
                        //$day = $v1['day'];
                        foreach ($v1['sort'] as $k2 => &$v2) {
                            if ($v2['is_use'] == false) {
                                $time_unix = strtotime($v1['year'] . '-' . $v1['day'] . $v2['time_str']);
                                //根据服务时长获取时间区间
                                $goods_time_start = $time_unix;
                                $sever_time_unix = sever_time($sever_time) * 60;
                                $goods_time_end = $time_unix + $sever_time_unix;
                                if (!($goods_time_end <= $start_time || $goods_time_start >= $end_time)) {
                                    $v2['is_use'] = true;
                                }
                            }
                        }
                    }
                }

            }
        }
        return $this->successResponse(200, '成功', $appoint_str);
    }

    /**
     * 根据店铺id，日期，服务师被占用的时间返还时间点
     * @param $shop_id
     * @param $day
     * @param $use_hour
     * @return mixed
     */
    public function _getTimeByShopOpenTime($shop_id, $day, $sever_time, $use_time, $open_appoint)
    {
        //获取店铺的营业时间
        $shop_open_time = DB::table('wr_shop')
            ->where('id', $shop_id)
            ->value('open_time');
        //获取店铺营业时间
        $open_time = explode('-', $shop_open_time);
        $shop_start_time = strtotime(trim($open_time[0]));
        $shop_end_time = strtotime(trim($open_time[1]));
        //获取营业起始时间（分钟，小时）
        $shop_start_i = date('i', $shop_start_time);
        $shop_start_h = date('H', $shop_start_time);
        //获取营业结束时间（分钟，小时）
        $shop_end_i = date('i', $shop_end_time);
        $shop_end_h = date('H', $shop_end_time);
        //营业起始时间 ，整点、半小时生成
        if ($shop_start_i > 0 && $shop_start_i < 30) {
            $start_time = $shop_start_h . ':30';
        } elseif ($shop_start_i > 30 && $shop_start_i < 60) {
            $start_time = ($shop_start_h + 1) . ':00';
        } else {
            $start_time = $shop_start_h . ':' . $shop_start_i;
        }
        //营业结束时间 ，整点、半小时生成
        if ($shop_end_i > 0 && $shop_end_i < 30) {
            $end_time = $shop_end_h . ':00';
        } elseif ($shop_end_i > 30 && $shop_end_i < 60) {
            $end_time = ($shop_end_h) . ':30';
        } else {
            $end_time = $shop_end_h . ':' . $shop_end_i;
        }
        //根据店铺营业时间,当前时间,获取可预约的起始时间，结束时间
        $start_sort = DB::table('wr_time_relation')
            ->where('time_str', $start_time)
            ->value('id_sort');
        $end_sort = DB::table('wr_time_relation')
            ->where('time_str', $end_time)
            ->value('id_sort');

        $all_sort_obj = DB::table('wr_time_relation')
            ->where('id_sort', '>=', $start_sort)
            ->where('id_sort', '<=', $end_sort)
            ->select('id_sort', 'time_str')
            ->get();

        if ($open_appoint == 1) {
            $now_sort = 1;
        } else {
            //判断是不是今天
            $c = date('Y-m-d');
            if ($day == $c) {
                //获取当前时间小时、分钟
                $now_min = date('i', time());
                $now_h = date('H', time());
                if ($now_min > '0' && $now_min < '30') {
                    $now_start_time = $now_h . ':30';
                } elseif ($now_min > '30' && $now_min < '60') {
                    $now_start_time = ($now_h + 1) . ':00';
                } else {
                    $now_start_time = $now_h . ':' . $now_min;
                }
                //获取当前id_sort
                $now_sort = DB::table('wr_time_relation')
                    ->where('time_str', $now_start_time)
                    ->value('id_sort');
                $now_sort = $now_sort + 1;
            } else {
                $now_sort = 1;
            }
        }
        //获取可预约的时间列表
        if (empty($use_time)) {
            $time_obj = DB::table('wr_time_relation')
                ->where('id_sort', '>=', $start_sort)
                ->where('id_sort', '<=', $end_sort)
                ->where('id_sort', '>=', $now_sort)
                ->select('id_sort', 'time_str')
                ->get();
            if(count($time_obj)==0){
                $time_obj = array();
            }
        } else {
            $time_obj = DB::table('wr_time_relation')
                ->where('id_sort', '>=', $start_sort)
                ->where('id_sort', '<=', $end_sort)
                ->where('id_sort', '>=', $now_sort)
                ->whereNotIn('id_sort', $use_time)
                ->select('id_sort', 'time_str')
                ->get();
            if(count($time_obj)==0){
                $time_obj = array();
            }
        }
        if(count($time_obj)==0){
            $shop_appoint_time = array();
        }else{
            //获取可预约的时间节点
            foreach ($time_obj as $k => $v) {
                $shop_appoint_time[$k]['id_sort'] = $v->id_sort;
                $shop_appoint_time[$k]['time_str'] = $v->time_str;
            }
        }

        if ($open_appoint == 1) {
            //店铺全部的时间节点
            foreach ($all_sort_obj as $k => $v) {
                $all_appoint_time[$k]['id_sort'] = $v->id_sort;
                $all_appoint_time[$k]['time_str'] = $v->time_str;
                $all_appoint_time[$k]['is_use_test'] = true;
                $all_appoint_time[$k]['is_use'] = true;
            }
        } else {
            //店铺全部的时间节点
            foreach ($all_sort_obj as $k => $v) {
                $all_appoint_time[$k]['id_sort'] = $v->id_sort;
                $all_appoint_time[$k]['time_str'] = $v->time_str;
                $all_appoint_time[$k]['is_use_test'] = in_array($v->time_str, array_dot($shop_appoint_time), true) == true ? false : true;
            }
            $count = count($all_appoint_time);
            for ($i = 0; $i <= $count - $sever_time; $i++) {
                $all_appoint_time[$i]['is_use'] = false;
                for ($k = 0; $k < $sever_time - 1; $k++) {
                    $all_appoint_time[$count - $sever_time + 1 + $k]['is_use'] = true;
                }

                for ($j = 0; $j < $sever_time; $j++) {
                    if ($all_appoint_time[$i + $j]['is_use_test'] == true) {
                        $all_appoint_time[$i]['is_use'] = true;
                        continue;
                    }
                }
            }
        }
        return $all_appoint_time;
    }

    /**
     * 预约信息提交
     * @POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function appointStore(Request $request)
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $shop_id = $this->getMesByToken()['shop_id'];
        $member_id = $this->getMesByToken()['id'];
        $waiter_id = $this->dealStr($request->input('waiter_id'));
        $goods_id = $this->dealStr($request->input('goods_id'));
        $remark = $this->dealStr($request->input('remark'));
        $appoint_time = $this->dealStr($request->input('appoint_time'));
        $id_sort = $this->dealStr($request->input('id_sort'));

        if (empty($waiter_id) || empty($goods_id) ||
            empty($appoint_time) || empty($id_sort)
        ) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }

        $appoint_id = create_appoint_num();
        $appoint_time_unix = strtotime($appoint_time);
        $time_date = date('Y-m-d', $appoint_time_unix);
        //获取产品的服务时长
        $goods_sever_time = DB::table('wr_goods_cate')
            ->where('id', $goods_id)
            ->value('sever_time');
        if (empty($goods_sever_time)) {
            return $this->errorResponse(406, '数据库异常');
        }

        $time_hour = array();
        switch ($goods_sever_time) {
            case 1:
                $time_hour = array($id_sort);
                break;
            case 2:
                $time_hour = array($id_sort, $id_sort + 1);
                break;
            case 3:
                $time_hour = array($id_sort, $id_sort + 1, $id_sort + 2);
                break;
            case 4:
                $time_hour = array($id_sort, $id_sort + 1, $id_sort + 2, $id_sort + 3);
                break;
            case 5:
                $time_hour = array($id_sort, $id_sort + 1, $id_sort + 2, $id_sort + 3, $id_sort + 4);
                break;
            case 6:
                $time_hour = array($id_sort, $id_sort + 1, $id_sort + 2, $id_sort + 3, $id_sort + 4, $id_sort + 5);
                break;
            case 7:
                $time_hour = array($id_sort, $id_sort + 1, $id_sort + 2, $id_sort + 3, $id_sort + 4, $id_sort + 5, $id_sort + 6);
                break;
            case 8:
                $time_hour = array($id_sort, $id_sort + 1, $id_sort + 2, $id_sort + 3, $id_sort + 4, $id_sort + 5, $id_sort + 6, $id_sort + 7);
                break;
            case 9:
                $time_hour = array($id_sort, $id_sort + 1, $id_sort + 2, $id_sort + 3, $id_sort + 4, $id_sort + 5, $id_sort + 6, $id_sort + 7,$id_sort + 8);
                break;
            case 10:
                $time_hour = array($id_sort, $id_sort + 1, $id_sort + 2, $id_sort + 3, $id_sort + 4, $id_sort + 5, $id_sort + 6, $id_sort + 7,$id_sort + 8,$id_sort + 9);
                break;
            case 11:
                $time_hour = array($id_sort, $id_sort + 1, $id_sort + 2, $id_sort + 3, $id_sort + 4, $id_sort + 5, $id_sort + 6, $id_sort + 7,$id_sort + 8,$id_sort + 9,$id_sort + 10);
                break;
            case 12:
                $time_hour = array($id_sort, $id_sort + 1, $id_sort + 2, $id_sort + 3, $id_sort + 4, $id_sort + 5, $id_sort + 6, $id_sort + 7,$id_sort + 8,$id_sort + 9,$id_sort + 10,$id_sort + 11);
                break;
        }
        //判断该时间是否已经被预约
        $use_sort_time = DB::table('wr_waiter_appoint_time')
            ->where('waiter_id', $waiter_id)
            ->where('shop_id', $shop_id)
            ->where('merchant_id', $merchant_id)
            ->where('time_date', $time_date)
            ->whereIn('time_hour', $time_hour)
            ->where('status', 1)
            ->pluck('id');
        if (!empty($use_sort_time)) {
            return $this->errorResponse(201, '该时间已经被预约');
        }
        $attr = array();
        $attr['merchant_id'] = $merchant_id;
        $attr['shop_id'] = $shop_id;
        $attr['waiter_id'] = $waiter_id;
        $attr['member_id'] = $member_id;
        $attr['goods_id'] = $goods_id;
        $attr['remark'] = $remark;
        $attr['appoint_id'] = $appoint_id;
        $attr['tel'] = DB::table('wr_member')
            ->where('id', $member_id)
            ->value('tel');
        $attr['time_date'] = $time_date;
        $attr['time_str'] = $appoint_time_unix;
        $attr['time_hour'] = $id_sort;
        //获取服务师被占用的数据
        $waiter_use = $this->_backWaiterUseArr($goods_id, $waiter_id, $merchant_id, $shop_id, $time_date, $id_sort, $appoint_id);
        //var_dump($attr);var_dump($waiter_use);exit;
        $res = $this->appoint->appointStore($attr, $waiter_use);
        if ($res) {
            //预约次数限制
            $appoint_num = Cache::get((date('Y-m-d') . $member_id)) ? Cache::get((date('Y-m-d') . $member_id)) : 0;
            if ($appoint_num <= config('constants.CAN_APPOINT_NUM')) {
                $appoint_num += 1;
                Cache::put((date('Y-m-d') . $member_id), $appoint_num, config('constants.ONE_DAT'));
            }
            //发送消息给服务师
            $member_arr = (array)DB::table('wr_member')
                ->where('id', $member_id)
                ->select('open_id', 'member_name')
                ->first();
            $time_hour_text = date('H:i', $appoint_time_unix);
            $goods_two_text_arr = (array)DB::table('wr_goods_cate')
                ->where('id', $goods_id)
                ->select('goods_name', 'price', 'sever_time')
                ->first();
            $member_tel = $attr['tel'];
            $goods_two_text = $goods_two_text_arr['goods_name'];
            $good_price = $goods_two_text_arr['price'];
            $member_name = $member_arr['member_name'];
            $data = appoint_ok_notice_waiter($member_name, $time_date, $time_hour_text, $goods_two_text, $member_tel, $remark, $good_price);
            //模板类型  通知服务师
            $template_type = 'NOTICE_HAIR_OK';
            $wx_waiter_open_id = DB::table('wr_waiter')
                ->where('id', $waiter_id)
                ->value('open_id');
            $url = 'http://waiter.weerun.com/#/Appointment';
            $job = (new AppointNotice($merchant_id, $wx_waiter_open_id, $template_type, $data, $url));
            $this->dispatch($job);

            //发送消息给客户
            $shop_arr = (array)DB::table('wr_shop')
                ->where('id', $shop_id)
                ->select('shop_name', 'tel')
                ->first();
            $shop_name = $shop_arr['shop_name'];
            $shop_tel = $shop_arr['tel'];
            //服务师的名字
            $waiter_name = DB::table('wr_waiter')
                ->where('id', $waiter_id)
                ->value('nickname');
            //服务时长
            $appoint_server_time_text = sever_time($goods_two_text_arr['sever_time']);
            //客户的open_id
            $wx_member_open_id = $member_arr['open_id'];
            $data = appoint_ok_notice_member($member_name, $time_date, $time_hour_text, $goods_two_text, $shop_name, $shop_tel, $waiter_name, $appoint_server_time_text);
            $template_type = 'NOTICE_MEMBER_OK';
            //会员我的预约首页
            $url1 = 'http://member.weerun.com/#/Userappointgoing';
            $job1 = (new AppointNotice($merchant_id, $wx_member_open_id, $template_type, $data, $url1));
            $this->dispatch($job1);
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(406, '数据库异常');
        }

    }

    /**
     * 预约信息展示
     * @get
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function appointEdit(Request $request)
    {
        $shop_id = $this->getMesByToken()['shop_id'];
        $waiter_id = $this->dealStr($request->input('waiter_id'));
        $goods_id = $this->dealStr($request->input('goods_id'));
        if (empty($waiter_id) || empty($goods_id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $goods_arr = DB::table('wr_goods_cate')
            ->where('id', $goods_id)
            ->select('goods_name', 'sever_time', 'price')
            ->first();
        $shop_name = DB::table('wr_shop')
            ->where('id', $shop_id)
            ->value('shop_name');
        $waiter_arr = DB::table('wr_waiter')
            ->where('id', $waiter_id)
            ->select('nickname', 'img')
            ->first();
        $attr = array();
        $attr['waiter_name'] = $waiter_arr->nickname;
        $attr['waiter_img'] = $waiter_arr->img;
        $attr['shop_name'] = $shop_name;
        $attr['goods_name'] = $goods_arr->goods_name;
        $attr['price'] = $goods_arr->price;
        $attr['sever_time'] = sever_time($goods_arr->sever_time);
        return $this->successResponse(200, '成功', $attr);
    }

    /**
     * 返回服务师的预约时间信息，写入表
     * @param $goods_id
     * @param $waiter_id
     * @param $merchant_id
     * @param $shop_id
     * @param $time_date
     * @param $id_sort
     * @param $appoint_id
     * @return array
     */
    public function _backWaiterUseArr($goods_id, $waiter_id, $merchant_id, $shop_id, $time_date, $id_sort, $appoint_id)
    {
        $attr = array();
        $goods_time = DB::table('wr_goods_cate')
            ->where('id', $goods_id)
            ->value('sever_time');
        for ($i = 0; $i < $goods_time; $i++) {
            $attr[$i]['waiter_id'] = $waiter_id;
            $attr[$i]['merchant_id'] = $merchant_id;
            $attr[$i]['shop_id'] = $shop_id;
            $attr[$i]['time_date'] = $time_date;
            $attr[$i]['time_hour'] = $id_sort + $i;
            $attr[$i]['appoint_id'] = $appoint_id;
            $attr[$i]['status'] = 1;
        }
        return $attr;
    }

}

