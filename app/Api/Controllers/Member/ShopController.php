<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:21
 */

namespace App\Api\Controllers\Member;

use App\Api\Controllers\ApiBaseController;
use App\Api\Transformer\ShopTransformer;
use Illuminate\Http\Request;
use App\Repositories\Contracts\ShopRepository;
use Illuminate\Support\Facades\DB;
use Cache;
use Config;
use Log;

/**
 * Class ShopController
 * @package App\Api\Controllers\Member
 */
class ShopController extends ApiBaseController
{
    private $shop;
    protected $shopTransformer;

    public function __construct(ShopRepository $shopRepository, ShopTransformer $shopTransformer)
    {
        $this->shop = $shopRepository;
        $this->shopTransformer = $shopTransformer;
    }

    /**
     * @POST
     * 门店列表
     * @param Request $request
     * @param ShopRepositoryEloquent $shopRepositoryEloquent
     * @return \Illuminate\Http\JsonResponse
     */
    public function shopList(Request $request)
    {
        $shop_id = $request->input('shop_id');
        //纬度值
        $lat1 = $this->dealStr($request->input('lat'));
        //经度值
        $lng1 = $this->dealStr($request->input('lng1'));
        if(empty($shop_id)){
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $shop_list = $this->shop->shopList($shop_id);
        if($shop_list){
            if (!empty($lat1) && !empty($lng1)) {
                foreach ($shop_list as $k => &$v) {
                    $lat2 = $v['latitude'];
                    $lng2 = $v['longitude'];
                    $v['distance'] = getDistance($lat1, $lng1, $lat2, $lng2);
                    $gl = $v['distance'] / 1000;
                    $juLi = round($gl, 2);
                    if ($juLi == 0) {
                        $juLi = $v['distance'] . ' m';
                    } else {
                        $juLi .= ' Km';
                    }
                    $v['juli'] = $juLi;

                    $shop_img = array(
                        $v['img0'], $v['img1'],
                        $v['img2'], $v['img3']
                    );
                    $shop_arr['img'] = array_filter($shop_img);
                    $v['img'] = array_merge($shop_arr['img']);



                }
            } else {
                foreach ($shop_list as $k1 => &$v1) {
                    $v1['distance'] = null;
                    $v1['juli'] = null;
                    $shop_img = array(
                        $v1['img0'], $v1['img1'],
                        $v1['img2'], $v1['img3']
                    );
                    $shop_arr['img'] = array_filter($shop_img);
                    $v1['img'] = array_merge($shop_arr['img']);
                }
            }
            usort($shop_list, function ($a, $b) {
                $al = $a['distance'];
                $bl = $b['distance'];
                if ($al == $bl)
                    return 0;
                return ($al > $bl) ? 1 : -1;
            });
            return $this->successResponse(200, '成功', $this->shopTransformer->memberShopListTransformer($shop_list));
        }else{
            return $this->errorResponse(404, '失败');
        }
    }

    /**
     * 门店首页信息
     * @GET
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    /*public function shopIndex(Request $request)
    {
        //纬度值
        $lat1 = $this->dealStr($request->input('lat'));
        //经度值
        $lng1 = $this->dealStr($request->input('lng1'));

        $shop_id = $this->getMesByToken()['shop_id'];
        $shop_arr = $this->shop->indexByShopId($shop_id);
        if ($shop_arr) {
            $shop_img = array(
                $shop_arr['img0'], $shop_arr['img1'],
                $shop_arr['img2'], $shop_arr['img3']
            );
            $shop_arr['img'] = array_filter($shop_img);
            $shop_arr['img'] = array_merge($shop_arr['img']);
            return $this->successResponse(200, '成功', $this->shopTransformer->memberTransformer($shop_arr));
        } else {
            return $this->errorResponse(406, '失败');
        }
    }*/

    /**
     * 门店详情
     * @GET
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function shopShow(Request $request)
    {
        //纬度值
        $lat1 = $this->dealStr($request->input('lat'));
        //经度值
        $lng1 = $this->dealStr($request->input('lng1'));
        
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $shop_id = $this->getMesByToken()['shop_id'];
        $shop_arr = $this->shop->show($shop_id);
        if ($shop_arr) {
            if (!empty($lat1) && !empty($lng1)) {
                //门店的纬度值
                $lat2 = $shop_arr['latitude'];
                //门店的经度值
                $lng2 = $shop_arr['longitude'];
                //获取经纬度计算距离
                $distance = getDistance($lat1, $lng1, $lat2, $lng2);
                $gl = $distance / 1000;         //公里
                $juLi = round($gl, 2);   //浮点数进行四舍五入2位小数点
                if ($juLi == 0) {
                    $juLi = $distance . ' m';
                } else {
                    $juLi .= ' Km';
                }
            } else {
                $juLi = '';
            }
            $shop_arr['juli'] = $juLi;
            //预约数量
            $shop_arr['appoint_num'] = DB::table('wr_appoint')
                ->where('shop_id', $shop_id)
                ->where('merchant_id', $merchant_id)
                ->count();
            $shop_img = array(
                $shop_arr['img0'], $shop_arr['img1'],
                $shop_arr['img2'], $shop_arr['img3']
            );
            //具体地址
            $shop_arr['address'] = $shop_arr['address'].$shop_arr['detail_address'];
            $shop_arr['img'] = array_filter($shop_img);
            $shop_arr['img'] = array_merge($shop_arr['img']);
            return $this->successResponse(200, '成功', $this->shopTransformer->memberShopShowTransformer($shop_arr));
        } else {
            return $this->errorResponse(406, '失败');
        }
    }
}

