<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\AppointRankRepository as AppointRankRepositoryInterface;
use App\Models\Appoint;

/**
 * Class WaiterAlbumRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class AppointRankRepositoryEloquent extends BaseRepository implements AppointRankRepositoryInterface
{
    /**
     * @return mixed
     */
    public function model()
    {
        return Appoint::class;
    }

    /**
     * 服务师预约排行   根据时间区间
     * @param $merchant_id
     * @param $time_arr
     * @return array|bool
     */
    public function waiterRankByTime($merchant_id, $time_arr)
    {
        $arr = DB::table('wr_waiter')
            ->where('merchant_id', $merchant_id)
            ->select('nickname', 'id', 'img', 'level')
            ->get();
        if ($arr != null) {
            $attr = array();
            foreach ($arr as $k => $value) {
                $waiter_id = $value->id;
                $waiter_level_id = $value->level;
                $attr[$k]['nickname'] = $value->nickname;
                $attr[$k]['img'] = $value->img;

                $shop_id = DB::table('wr_shop_waiter')
                    ->where('waiter_id', $waiter_id)
                    ->where('merchant_id', $merchant_id)
                    ->pluck('shop_id');
                $shop_name = DB::table('wr_shop')
                    ->whereIn('id', $shop_id)
                    ->pluck('shop_name');

                $attr[$k]['shop_name'] = $shop_name;
                $attr[$k]['waiter_level'] = DB::table('wr_waiter_level')
                    ->where('merchant_id', $merchant_id)
                    ->where('id', $waiter_level_id)
                    ->value('name');
                $attr[$k]['appoint_num'] = $this->model
                    ->withTrashed()
                    ->where('merchant_id', $merchant_id)
                    ->where('waiter_id', $waiter_id)
                    ->where('status',2)
                    ->whereBetween('time_str', $time_arr)
                    ->count();
            }
            usort($attr, function ($a, $b) {
                $al = $a['appoint_num'];
                $bl = $b['appoint_num'];
                if ($al == $bl)
                    return 0;
                return ($al > $bl) ? -1 : 1;
            });
            return $attr;
        } else {
            return false;
        }
    }

    /**
     * 服务师预约排行   根据时间区间(根据门店id)
     * @param $merchant_id
     * @param $time_arr
     * @return array|bool
     */
    public function waiterRankByTimeByShop($merchant_id, $shop_id,$time_arr)
    {
        $arr = DB::table('wr_waiter')
            ->where('merchant_id', $merchant_id)
            ->select('nickname', 'id', 'img', 'level')
            ->get();
        if ($arr != null) {
            $attr = array();
            foreach ($arr as $k => $value) {
                $waiter_id = $value->id;
                $waiter_level_id = $value->level;
                $attr[$k]['nickname'] = $value->nickname;
                $attr[$k]['img'] = $value->img;
                $shop_name = DB::table('wr_shop')
                    ->where('id', $shop_id)
                    ->pluck('shop_name');

                $attr[$k]['shop_name'] = $shop_name;
                $attr[$k]['waiter_level'] = DB::table('wr_waiter_level')
                    ->where('merchant_id', $merchant_id)
                    ->where('id', $waiter_level_id)
                    ->value('name');
                $attr[$k]['appoint_num'] = $this->model
                    ->withTrashed()
                    ->where('shop_id',$shop_id)
                    ->where('merchant_id', $merchant_id)
                    ->where('status',2)
                    ->where('waiter_id', $waiter_id)
                    ->whereBetween('time_str', $time_arr)
                    ->count();
            }
            usort($attr, function ($a, $b) {
                $al = $a['appoint_num'];
                $bl = $b['appoint_num'];
                if ($al == $bl)
                    return 0;
                return ($al > $bl) ? -1 : 1;
            });
            return $attr;
        } else {
            return false;
        }
    }

    /**
     * 根据日期获取预约数量
     * @param $merchant_id
     * @param $day
     * @return mixed
     */
    public function appointByDay($merchant_id, $day)
    {
        return $num = $this->model
                ->withTrashed()
                ->where('merchant_id',$merchant_id)
                ->where('time_date',$day)
                ->where('status',2)
                ->count();
    }

    /**
     * 根据时间区间获取预约数量
     * @param $merchant_id
     * @param $time_arr
     * @return mixed
     */
    public function appointByDayInterval($merchant_id, $time_arr)
    {
        return $num = $this->model
            ->withTrashed()
            ->where('merchant_id',$merchant_id)
            ->where('status',2)
            ->whereBetween('time_str',$time_arr)
            ->count();
    }

    /**
     * 根据店铺id ，日期获取预约数量
     * @param $merchant_id
     * @param $shop_id
     * @param $day
     * @return mixed
     */
    public function appointByDayByShop($merchant_id, $shop_id, $day)
    {
        return $num = $this->model
            ->withTrashed()
            ->where('merchant_id',$merchant_id)
            ->where('shop_id',$shop_id)
            ->where('time_date',$day)
            ->where('status',2)
            ->count();
    }

    /**
     * 根据店铺id,日期获取预约数量
     * @param $merchant_id
     * @param $shop_id
     * @param $time_arr
     * @return mixed
     */
    public function appointByDayIntervalByShop($merchant_id, $shop_id, $time_arr)
    {
        return $num = $this->model
            ->withTrashed()
            ->where('merchant_id',$merchant_id)
            ->where('shop_id',$shop_id)
            ->where('status',2)
            ->whereBetween('time_str',$time_arr)
            ->count();
    }
    
    //服务师端

    /**
     * 服务师的预约统计（根据日期）
     * @param $waiter_id
     * @param $day
     * @return mixed
     */
    public function waiterAppointByDay($waiter_id, $day)
    {
        return $num = $this->model
            ->withTrashed()
            ->where('waiter_id',$waiter_id)
            ->where('time_date',$day)
            ->where('status',2)
            ->count();
    }

    /**
     * 服务师的预约统计（根据时间区间）
     * @param $waiter_id
     * @param $time_arr
     * @return mixed
     */
    public function waiterAppointByDayInterval($waiter_id, $time_arr)
    {
        return $num = $this->model
            ->withTrashed()
            ->where('waiter_id',$waiter_id)
            ->where('status',2)
            ->whereBetween('time_str',$time_arr)
            ->count();
    }

    /**
     * 根据门店id，获取服务师的预约统计（根据日期）
     * @param $waiter_id
     * @param $shop_id
     * @param $day
     * @return mixed
     */
    public function waiterAppointByDayByShop($waiter_id, $shop_id, $day)
    {
        return $num = $this->model
            ->withTrashed()
            ->where('waiter_id',$waiter_id)
            ->where('shop_id',$shop_id)
            ->where('time_date',$day)
            ->where('status',2)
            ->count();
    }

    /**
     * 根据门店id，获取服务师的预约统计（根据时间区间）
     * @param $waiter_id
     * @param $shop_id
     * @param $time_arr
     * @return mixed
     */
    public function waiterAppointByDayIntervalByShop($waiter_id, $shop_id, $time_arr)
    {
        return $num = $this->model
            ->withTrashed()
            ->where('waiter_id',$waiter_id)
            ->where('shop_id',$shop_id)
            ->where('status',2)
            ->whereBetween('time_str',$time_arr)
            ->count();
    }
}
