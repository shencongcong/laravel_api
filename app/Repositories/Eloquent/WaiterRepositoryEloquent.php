<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\WaiterRepository as WaiterRepositoryInterface;
use App\Models\Waiter;
use Cache;

/**
 * Class MenuRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class WaiterRepositoryEloquent extends BaseRepository implements WaiterRepositoryInterface
{
    //商户管理端
    /**
     * Specify Model class name
     * @return string
     */
    public function model()
    {
        return Waiter::class;
    }

    /**
     * 商户端所有服务师
     * @param $merchant_id
     * @return array|bool
     */
    public function index($merchant_id)
    {
        $res = Cache::get('WaiterRepositoryEloquent_index' . $merchant_id);
        //$res = false;
        if ($res) {
            return $res;
        } else {
            try {
                $waiter_obj = DB::table('wr_waiter')
                    ->leftjoin('wr_shop_waiter', 'wr_shop_waiter.waiter_id', '=', 'wr_waiter.id')
                    ->leftjoin('wr_shop', 'wr_shop.id', '=', 'wr_shop_waiter.shop_id')
                    ->where(['wr_waiter.merchant_id' => $merchant_id, 'wr_shop.deleted_at' => null, 'wr_waiter.deleted_at' => null])
                    ->select('wr_waiter.id', 'wr_waiter.nickname', 'wr_waiter.img', 'wr_shop.shop_name', 'wr_waiter.level')
                    ->get();
                // dd($waiter_obj);
                if (count($waiter_obj) >= 1) {
                    foreach ($waiter_obj as $k => &$v) {
                        $v->name = DB::table('wr_waiter_level')
                            ->where('id', $v->level)
                            ->where('merchant_id', $merchant_id)
                            ->value('name');
                    }
                    Cache::put('WaiterRepositoryEloquent_index' . $merchant_id, $waiter_obj, Config('constants.THREE_MINUTE'));
                    return $waiter_obj;
                } else {
                    return 204;
                }
            } catch (\Exception $e) {
                return 406;
            }
        }

    }

    /**
     * 商户端服务师信息展示
     * @param $id
     * @return bool|mixed
     */
    public function show($id)
    {
        $res = Cache::get('WaiterRepositoryEloquent_show' . $id);
        if ($res) {
            return $res;
        } else {
            try {
                $waiter = DB::table('wr_waiter')
                    ->join('wr_shop_waiter', 'wr_shop_waiter.waiter_id', '=', 'wr_waiter.id')
                    ->join('wr_shop', 'wr_shop.id', '=', 'wr_shop_waiter.shop_id')
                    ->where('wr_waiter.id', $id)
                    ->select(
                        'wr_waiter.id', 'wr_waiter.nickname', 'wr_waiter.img',
                        'wr_shop.shop_name', 'wr_waiter.tel', 'wr_waiter.level',
                        'wr_waiter.work_length', 'wr_waiter.sex', 'wr_waiter.brief'
                    )
                    ->first();
                if ($waiter) {
                    $waiter = (array)$waiter;
                    $waiter['name'] = DB::table('wr_waiter_level')
                        ->where('id', $waiter['level'])
                        ->value('name');
                    Cache::put('WaiterRepositoryEloquent_show' . $id, $waiter, Config('constants.THREE_MINUTE'));
                    return $waiter;
                } else {
                    return 204;
                }
            } catch (\Exception $e) {
                return 406;
            }
        }
    }

    /**
     * 商户端服务师删除
     * @param $waiter_id
     * @param $merchant_id
     * @return bool
     */
    public function destroy($waiter_id, $merchant_id)
    {
        try {
            $waiter = $this->model->find($waiter_id);
            if ($waiter) {
                $waiter->delete();
                if ($waiter->trashed()) {
                    Cache::forget('WaiterRepositoryEloquent_index' . $merchant_id);
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return 406;
        }

    }

    /**
     * 商户端 根据店铺id 展示门店下的所有服务师
     * @param $shopId
     * @return array|bool
     */
    public function waiterByShop($shopId)
    {
        try {
            $waiter_obj = DB::table('wr_shop_waiter')
                ->leftjoin('wr_waiter', 'wr_shop_waiter.waiter_id', '=', 'wr_waiter.id')
                ->leftjoin('wr_shop', 'wr_shop_waiter.shop_id', '=', 'wr_shop.id')
                ->where(['wr_shop_waiter.shop_id' => $shopId, 'wr_waiter.deleted_at' => null])
                ->select(
                    'wr_waiter.id', 'wr_waiter.nickname', 'wr_waiter.img',
                    'wr_waiter.level', 'wr_shop.shop_name'
                )
                ->get();
            if ($waiter_obj) {
                foreach ($waiter_obj as $k => &$v) {
                    //服务师职位
                    $v->name = DB::table('wr_waiter_level')
                        ->where('id', $v->level)
                        ->value('name');
                }
                return $waiter_obj;
            } else {
                return [];
            }
        } catch (\Exception $e) {
            return 406;
        }
    }


    //服务师端
    /**
     * 根据服务师电话，获取服务师的商户id
     * @param $tel
     * @return bool
     */
    public function showByTel($tel)
    {
        $arr_obj = $this->model
            ->where('tel', $tel)
            ->select('id', 'merchant_id')
            ->get();
        if (count($arr_obj) !== 0) {
            $arr = $arr_obj->toArray();
            return $arr;
        } else {
            return false;
        }
    }

    /**
     * @param $open_id
     * @return bool
     */
    public function showByOpenId($open_id)
    {
        $arr_obj = $this->model
            ->join('wr_merchant','wr_merchant.id','=','wr_waiter.merchant_id')
            ->where('wr_waiter.open_id', $open_id)
            ->select('wr_waiter.id', 'wr_waiter.merchant_id')
            ->get();
        if (count($arr_obj) !== 0) {
            $arr = $arr_obj->toArray();
            return $arr;
        } else {
            return false;
        }
    }

    /**
     * 根据商户id,tel 获取服务师的id
     * @param $merchant_id
     * @param $tel
     * @return bool
     */
    public function getWaiterId($merchant_id, $tel)
    {
        $res = $this->model
            ->where('merchant_id', $merchant_id)
            ->where('tel', $tel)
            ->value('id');
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    /**
     * 根据商户id,open_id 获取服务师的id
     * @param $merchant_id
     * @param $open_id
     * @return bool
     */
    public function getWaiterIdByOpenId($merchant_id, $open_id)
    {
        $res = $this->model
            ->where('merchant_id', $merchant_id)
            ->where('open_id', $open_id)
            ->value('id');
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    /**
     * 服务师信息编辑展示
     * @param $waiter_id
     * @return bool
     */
    public function waiterShow($waiter_id)
    {
        $res = Cache::get('WaiterRepositoryEloquent_waiterShow' . $waiter_id);
        if ($res) {
            return $res;
        } else {
            try {
                $arr_obi = $this->model
                    ->where('id', $waiter_id)
                    ->first();
                if (count($arr_obi) !== 0) {
                    $arr = $arr_obi->toArray();
                    Cache::put('WaiterRepositoryEloquent_waiterShow' . $waiter_id, $arr, Config('constants.THREE_MINUTE'));
                    return $arr;
                } else {
                    return 404;
                }
            } catch (\Exception $e) {
                return 406;
            }
        }
    }

    /**
     * 服务师信息更新
     * @param $id
     * @param $shop_arr
     * @param $goods_arr
     * @param $arr
     * @return bool
     */
    public function waiterUpdate($id, $shop_arr, $goods_arr, $arr)
    {
        DB::beginTransaction();
        try {
            /*
            * 1.删除wr_waiter_goods表里的数据
            * 2.更新新数据
            * */
            $del_one = DB::table('wr_waiter_goods')->where('waiter_id', $id)->delete();
            $del_two = DB::table('wr_shop_waiter')->where('waiter_id', $id)->delete();
            if ($del_one !== false && $del_two !== false) {
                $res1 = $this->model->where('id', $id)->update($arr);
                $res2 = DB::table('wr_shop_waiter')->insert($shop_arr);
                $res3 = DB::table('wr_waiter_goods')->insert($goods_arr);
                if ($res1 && $res2 && $res3) {
                    DB::commit();
                    Cache::forget('WaiterRepositoryEloquent_waiterShow' . $id);
                    return true;
                } else {
                    DB::rollBack();
                    return false;
                }
            } else {
                DB::rollBack();
                return false;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**服务师扫码注册
     * @param $all
     * @param $shop_id
     * @param $goods_id
     * @param $merchant_id
     * @param $open_id
     * @return bool
     */
    public function waiterRegister($all, $shop_id, $goods_id, $merchant_id, $open_id)
    {
        DB::beginTransaction();
        try {
            $res1 = $this->model->create($all);
            $shop_arr = array();
            foreach ($shop_id as $k => $v) {
                $shop_arr[$k]['merchant_id'] = $merchant_id;
                $shop_arr[$k]['waiter_id'] = $res1->id;
                $shop_arr[$k]['shop_id'] = $v;
            }
            $goods_arr = array();
            foreach ($goods_id as $k => $v) {
                $goods_arr[$k]['waiter_id'] = $res1->id;
                $goods_arr[$k]['goods_id'] = $v;
            }
            $res2 = DB::table('wr_shop_waiter')->insert($shop_arr);
            $res3 = DB::table('wr_waiter_goods')->insert($goods_arr);
            if ($res1 && $res2 && $res3) {
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
     * 根据职位获取服务师列表
     * @param $level_id
     * @param $shop_id
     * @param $merchant_id
     * @return bool
     */
    public function waiterListByLevel($level_id, $shop_id, $merchant_id)
    {
        $waiter_id = DB::table('wr_shop_waiter')
            ->where('shop_id', $shop_id)
            ->where('merchant_id', $merchant_id)
            ->pluck('waiter_id');
        if ($waiter_id) {
            $waiter_obj = $this->model
                ->where('merchant_id', $merchant_id)
                ->where('level', $level_id)
                ->whereIn('id', $waiter_id)
                ->select('nickname', 'level', 'img', 'id')
                ->get();
            if (count($waiter_obj) !== 0) {
                $waiter_arr = $waiter_obj->toArray();
                return $waiter_arr;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 服务师全部列表
     * @param $shop_id
     * @param $merchant_id
     * @return bool
     */
    public function waiterList($shop_id, $merchant_id)
    {
        $waiter_id = DB::table('wr_shop_waiter')
            ->where('shop_id', $shop_id)
            ->where('merchant_id', $merchant_id)
            ->pluck('waiter_id');
        if ($waiter_id) {
            $waiter_obj = $this->model
                ->where('merchant_id', $merchant_id)
                ->whereIn('id', $waiter_id)
                ->select('nickname', 'level', 'img', 'id')
                ->get();
            if (count($waiter_obj) !== 0) {
                $waiter_arr = $waiter_obj->toArray();
                return $waiter_arr;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 根据产品筛选服务师
     * @param $waiter_id
     * @return bool
     */
    public function waiterListByGoodsId($waiter_id)
    {
        $waiter_obj = $this->model
            ->whereIn('id', $waiter_id)
            ->select('nickname', 'level', 'img', 'id')
            ->get();
        if (count($waiter_obj)!==0) {
            $waiter_arr = $waiter_obj->toArray();
            foreach ($waiter_arr as $k => &$v) {
                $v['level_name'] = DB::table('wr_waiter_level')
                    ->where('id', $v['level'])
                    ->value('name');
            }
            return $waiter_arr;
        } else {
            return false;
        }
    }
}
