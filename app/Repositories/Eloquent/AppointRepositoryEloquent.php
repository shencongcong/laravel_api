<?php

namespace App\Repositories\Eloquent;

use App\models\Appoint;
use App\models\Member;
use App\models\Waiter;
use App\models\WaiterAppointTime;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\AppointRepository as AppointRepositoryInterface;
use Log;

/**
 * Class WaiterAlbumRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class AppointRepositoryEloquent extends BaseRepository implements AppointRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Appoint::class;
    }

    /**
     * @param $merchant_id
     * @param $status 1：预约中  2：预约完成（到店）
     * @param $reason 0：正常 1：客户取消  2：门店取消
     * @return array|bool
     */
    public function index($merchant_id, $status, $reason)
    {
        $arr_obj = $this->model
            ->where('merchant_id', $merchant_id)
            ->where('status', $status)
            ->where('reason', $reason)
            ->select(
                'member_id', 'shop_id', 'waiter_id',
                'time_date', 'time_hour', 'goods_id'
            )
            ->get();
        //return $arr;
        Log::info('arr_obj' . serialize($arr_obj));
        if (count($arr_obj) !== 0) {
            $arr = $arr_obj->toArray();
            foreach ($arr as $k => &$v) {
                $member_obj = Member::where('id', $v['member_id'])
                    ->select('img', 'member_name')
                    ->first();
                if (count($member_obj) !== 0) {
                    $member = $member_obj->toArray();
                    $v['member_name'] = $member['member_name'];
                    $v['member_img'] = $member['img'];
                } else {
                    $v['member_name'] = null;
                    $v['member_img'] = null;
                }
                $v['waiter_name'] = DB::table('wr_waiter')
                    ->where('id', $v['waiter_id'])
                    ->value('nickname');
                $v['shop_name'] = DB::table('wr_shop')
                    ->where('id', $v['shop_id'])
                    ->value('shop_name');
                $v['good_cate'] = DB::table('wr_goods_cate')
                    ->where('id', $v['goods_id'])
                    ->value('goods_name');
                $v['time_hour'] = DB::table('wr_time_relation')
                    ->where('id_sort', $v['time_hour'])
                    ->value('time_str');
            }
            return $arr;
        } else {
            return false;
        }
    }

    /**
     * @param $merchant_id
     * @param $status 1：预约中  2：预约完成（到店）
     * @param $reason 0：正常 1：客户取消  2：门店取消
     * @param $shop_id
     * @return array|bool
     */
    public function byShopAppoint($merchant_id, $status, $reason, $shop_id)
    {
        $arr_obj = $this->model
            ->where('merchant_id', $merchant_id)
            ->where('status', $status)
            ->where('reason', $reason)
            ->where('shop_id', $shop_id)
            ->select(
                'member_id', 'shop_id', 'waiter_id',
                'time_date', 'time_hour', 'goods_id'
            )
            ->get();
        if (count($arr_obj) !== 0) {
            $arr = $arr_obj->toArray();
            foreach ($arr as $k => &$v) {
                $member_obj = Member::where('id', $v['member_id'])
                    ->select('img', 'member_name')
                    ->first();
                if (count($member_obj) !== 0) {
                    $member = $member_obj->toArray();
                    $v['member_name'] = $member['member_name'];
                    $v['member_img'] = $member['img'];
                } else {
                    $v['member_name'] = null;
                    $v['member_img'] = null;
                }
                $v['waiter_name'] = DB::table('wr_waiter')
                    ->where('id', $v['waiter_id'])
                    ->value('nickname');
                $v['shop_name'] = DB::table('wr_shop')
                    ->where('id', $v['shop_id'])
                    ->value('shop_name');
                $v['good_cate'] = DB::table('wr_goods_cate')
                    ->where('id', $v['goods_id'])
                    ->value('goods_name');
                $v['time_hour'] = DB::table('wr_time_relation')
                    ->where('id_sort', $v['time_hour'])
                    ->value('time_str');
            }
            return $arr;
        } else {
            return false;
        }
    }


    //服务师端
    /**
     * 预约管理首页展示
     * @param $waiter_id
     * @param $status
     * @param $reason
     * @return bool
     */
    public function waiterIndex($waiter_id, $status, $reason)
    {
        $arr_obj = $this->model
            ->where('waiter_id', $waiter_id)
            ->where('status', $status)
            ->where('reason', $reason)
            ->orderBy('time_str')
            ->select(
                'member_id', 'shop_id', 'time_date', 'time_hour', 'goods_id', 'remark', 'tel', 'id'
            )
            ->get();
        if (count($arr_obj) !== 0) {
            $attr = $arr_obj->toArray();
            foreach ($attr as $k => &$v) {
                $member_obj = Member::where('id', $v['member_id'])
                    ->select('img', 'member_name')
                    ->first();
                if (count($member_obj) !== 0) {
                    $member = $member_obj->toArray();
                    $v['member_name'] = $member['member_name'];
                    $v['member_img'] = $member['img'];
                } else {
                    $v['member_name'] = null;
                    $v['member_img'] = null;
                }
                $v['waiter_name'] = DB::table('wr_waiter')
                    ->where('id', $waiter_id)
                    ->value('nickname');
                $v['shop_name'] = DB::table('wr_shop')
                    ->where('id', $v['shop_id'])
                    ->value('shop_name');
                $v['good_cate'] = DB::table('wr_goods_cate')
                    ->where('id', $v['goods_id'])
                    ->value('goods_name');
                $v['time_hour'] = DB::table('wr_time_relation')
                    ->where('id_sort', $v['time_hour'])
                    ->value('time_str');
            }
            return $attr;
        } else {
            return false;
        }
    }

    /**
     * 取消预约
     * @param $appoint_id
     * @param $arr
     * @return mixed
     */
    public function cancelUpdate($appoint_id, $arr)
    {
        DB::beginTransaction();
        try {
            $res1 = $this->model->where('appoint_id', $appoint_id)->update($arr);
            $res2 = DB::table('wr_waiter_appoint_time')
                ->where('appoint_id', $appoint_id)
                ->update(array('status' => 2));
            if ($res1 && $res2) {
                DB::commit();
                return true;
            } else {
                DB::rollBack();
                return false;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * 确认到店
     * @param $appoint_id
     * @param $arr
     * @return mixed
     */
    public function confirmShop($appoint_id, $arr)
    {
        return $this->model
            ->where('id', $appoint_id)
            ->where('reason', 0)
            ->update($arr);
    }

    /**
     * 预约删除
     * @param $appoint_id
     * @return mixed
     */
    public function destroy($appoint_id)
    {
        $res = $this->model->find($appoint_id);
        if ($res) {
            $res->delete();
            if ($res->trashed()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    //客户端
    /**
     * 我的预约首页
     * @param $member_id
     * @param $status
     * @param $reason
     * @return bool
     */
    public function memberIndex($member_id, $shop_id, $status, $reason)
    {
        $arr_obj = $this->model
            ->where('member_id', $member_id)
            ->where('shop_id', $shop_id)
            ->where('status', $status)
            ->where('reason', $reason)
            ->orderBy('time_str')
            ->select(
                'waiter_id', 'shop_id', 'time_date', 'time_hour', 'goods_id', 'remark', 'tel', 'id','is_comment'
            )
            ->get();
        if (count($arr_obj) !== 0) {
            $attr = $arr_obj->toArray();
            foreach ($attr as $k => &$v) {
                $waiter_obj = Waiter::where('id', $v['waiter_id'])
                    ->select('img', 'nickname', 'tel')
                    ->first();
                if (count($waiter_obj) !== 0) {
                    $waiter = $waiter_obj->toArray();
                    $v['waiter_name'] = $waiter['nickname'];
                    $v['waiter_img'] = $waiter['img'];
                    $v['waiter_tel'] = $waiter['tel'];
                } else {
                    $v['waiter_name'] = null;
                    $v['waiter_img'] = null;
                    $v['waiter_tel'] = null;
                }
                $v['shop_name'] = DB::table('wr_shop')
                    ->where('id', $v['shop_id'])
                    ->value('shop_name');
                $goods_arr = DB::table('wr_goods_cate')
                    ->where('id', $v['goods_id'])
                    ->select('goods_name', 'price')
                    ->first();
                $v['goods_name'] = $goods_arr->goods_name;
                $v['goods_price'] = $goods_arr->price;
                $v['time_hour'] = DB::table('wr_time_relation')
                    ->where('id_sort', $v['time_hour'])
                    ->value('time_str');
                
            }
            return $attr;
        } else {
            return false;
        }
    }


    /**
     * 新增预约
     * @param $attr
     * @param $waiter_use
     * @return bool
     */
    public function appointStore($attr, $waiter_use)
    {
        DB::beginTransaction();
        try {
            $res1 = $this->model->create($attr)->id;
            $res2 = DB::table('wr_waiter_appoint_time')->insert($waiter_use);
            if ($res1 && $res2) {
                DB::commit();
                return true;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * 根据预约id 获取预约信息
     * @param $appoint_id
     * @return bool
     */
    public function appointById($appoint_id)
    {
        $appoint_obj = $this->model
            ->where('id', $appoint_id)
            ->where('status', 1)
            ->first();
        if (count($appoint_obj) !== 0) {
            $appoint_arr = $appoint_obj->toArray();
            return $appoint_arr;
        } else {
            return false;
        }
    }
}
