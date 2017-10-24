<?php

namespace App\Repositories\Eloquent;

use Illuminate\Http\Request;
use Mockery\Exception;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\ShopRepository as ShopRepositoryInterface;
use App\Models\Shop;
use Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Log;

/**
 * Class MenuRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class ShopRepositoryEloquent extends BaseRepository implements ShopRepositoryInterface
{
    /**
     * Specify Model class name
     * @return string
     */
    public function model()
    {
        return Shop::class;
    }

    /**
     * 商户所有门店信息显示
     * @param $merchant_id
     * @return array|bool
     */
    public function index($merchant_id)
    {
        $res = Cache::get('ShopRepositoryEloquent_index' . $merchant_id);
        if ($res) {
            return $res;
        } else {
            $res_obj = $this->model->where('merchant_id', $merchant_id)->get();
            if (count($res_obj) !== 0) {
                $res = $res_obj->toArray();
                Cache::put('ShopRepositoryEloquent_index' . $merchant_id, $res, Config::get('constants.THREE_MINUTE'));
                return $res;
            } else {
                return false;
            }
        }
    }

    /**
     * 添加门店
     * @param $arr
     * @return bool
     */
    public function store($arr)
    {
        $res = $this->model->create($arr);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 店铺信息展示
     * @param $shop_id
     * @return bool|mixed
     */
    public function show($shop_id)
    {
        $res = Cache::get('ShopRepositoryEloquent_show' . $shop_id);
        if ($res) {
            return $res;
        } else {
            $shop_obj = $this->model
                ->where('id', $shop_id)
                ->first();
            if (count($shop_obj) !== 0) {
                $shop_arr = $shop_obj->toArray();
                Cache::put('ShopRepositoryEloquent_show' . $shop_id, $shop_arr, Config::get('constants.ONE_MINUTE'));
                return $shop_arr;
            } else {
                return false;
            }
        }

    }

    /**
     * 门店编辑
     * @param $shop_id
     * @param $arr
     * @return bool|int
     */
    public function shopUpdate($shop_id, $arr)
    {
        return $this->model->where('id', $shop_id)->update($arr);
    }

    /**
     * 门店删除
     * @param $shop_id
     * @return bool
     */
    public function destroy($shop_id, $merchant_id)
    {
        $post = $this->model->find($shop_id);
        if ($post) {
            $post->delete();
            if ($post->trashed()) {
                Cache::forget('ShopRepositoryEloquent_index' . $merchant_id);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 根据商户id获取门店的id和名称
     * @param $merchant_id
     * @return $this|bool
     */
    public function getShopList($merchant_id)
    {
        $shop_obj = $this->model->where('merchant_id', $merchant_id)
            ->select('id', 'shop_name')
            ->get();
        if (count($shop_obj) !== 0) {
            $shop = $shop_obj->toArray();
            return $shop;
        } else {
            return false;
        }
    }

    /*
     * 客户端 门店展示
     * */

    public function shopList($shop_id)
    {
        try{
            $res_obj = $this->model->find($shop_id);
            if (count($res_obj) !== 0) {
                $res = $res_obj->toArray();
                return $res;
            } else {
                return false;
            }
        }catch (Exception $e){
            Log::info(serialize('error'.$e));
        }

    }

    public function lgh($shop_id)
    {
        $res_obj = $this->model->find($shop_id);
        if (count($res_obj) !== 0) {
            $res = $res_obj->toArray();
            return $res;
        } else {
            return false;
        }
    }


    /*
     * 客户端 根据店铺id 门店展示
     * */
    public function indexByShopId($shop_id)
    {
        $res = Cache::get('ShopRepositoryEloquent_indexByShopId' . $shop_id);
        if ($res) {
            return $res;
        } else {
            $shop_obj = $this->model
                ->where('id', $shop_id)
                ->first();
            if (count($shop_obj) !== 0) {
                $shop_arr = $shop_obj->toArray();
                Cache::put('ShopRepositoryEloquent_indexByShopId' . $shop_id, $shop_arr, Config::get('constants.ONE_MINUTE'));
                return $shop_arr;
            } else {
                return false;
            }
        }
    }
    
}