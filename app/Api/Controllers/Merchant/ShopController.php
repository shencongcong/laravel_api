<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:21
 */

namespace App\Api\Controllers\Merchant;

use App\Api\Controllers\ApiBaseController;
use App\Api\Transformer\ShopTransformer;
use Illuminate\Http\Request;
use App\Repositories\Contracts\ShopRepository;
use Illuminate\Support\Facades\DB;
use Cache;

/**
 * Class ShopController
 * @package App\Api\Controllers
 */
class ShopController extends ApiBaseController
{
    /**
     * @var ShopRepository
     */
    private $shop;
    protected $shopTransformer;

    public function __construct(ShopRepository $shopRepository, ShopTransformer $shopTransformer)
    {
        $this->shop = $shopRepository;
        $this->shopTransformer = $shopTransformer;
    }

    /**
     * @GET
     * 所有门店信息显示
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $shop = $this->shop->index($merchant_id);
        if ($shop) {
            return $this->successResponse(200, '成功', $this->shopTransformer->transformer($shop));
        } else {
            return $this->errorResponse(204, '无内容');
        }
    }

    /**
     * @POST
     * 商户添加门店
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //检查商户允许添加的店铺数量
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $shop_num = DB::table('wr_merchant')
            ->where('id', $merchant_id)
            ->value('shop_nums');
        //获取已经存在的门店
        $shop = DB::table('wr_shop')
            ->where('merchant_id', $merchant_id)
            ->where('deleted_at',NULL)
            ->pluck('id');
        if (count($shop) >= $shop_num) {
            return $this->errorResponse(400, '已超过可添加的门店数');
        }
        $attr = $this->dealRequest($request->except('img'));
        //对客户端传入的数据进行过滤、校验数据完整性
        $img = $request->input('img');
        if (empty($attr['shop_name']) || empty($attr['address'])
            || empty($attr['tel']) || empty($attr['longitude'])
            || empty($attr['latitude']) || empty($attr['introduce'])
            || empty($attr['open_time'])
        ) {
            return $this->errorResponse(405, '缺少必要的参数');
        }
        if (!empty($img)) {
            foreach ($img as $k => $v) {
                $attr[$k] = $v;
            }
        }
        $attr['merchant_id'] = $this->getMesByToken()['merchant_id'];
        $attr['token'] = $this->_getWxToken($attr['merchant_id']);
        if (empty($attr['token'])) {
            return $this->errorResponse(408, '获取Token失败');
        }
        $res = $this->shop->store($attr);
        if ($res) {
            //删除缓存
            Cache::forget('ShopRepositoryEloquent_index'.$merchant_id);
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(400, '新建失败');
        }
    }

    /**
     * @POST
     * 门店信息修改
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $shop_id = $request->input('id');
        $attr = $this->dealRequest($request->except('img'));
        $img = $request->input('img');
        if (empty($attr['shop_name']) || empty($attr['address'])
            || empty($attr['tel']) || empty($attr['introduce'])
            || empty($attr['open_time'])
        ) {
            return $this->errorResponse(405, '缺少必要的参数');
        }
        if (!empty($img)) {
            foreach ($img as $k => $v) {
                $attr[$k] = $v;
            }
        }
        $res = $this->shop->shopUpdate($shop_id, $attr);
        if ($res) {
            //清除缓存
            Cache::forget('ShopRepositoryEloquent_index'.$merchant_id);
            Cache::forget('ShopRepositoryEloquent_show' . $shop_id);
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(400, '修改数据失败');
        }
    }

    /**
     *
     * 店铺信息展示
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $shop_id = $request->input('id');   //店铺id
        if (empty($shop_id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $arr = $this->shop->show($shop_id);
        if ($arr) {
            return $this->successResponse(200, '成功', $this->shopTransformer->oneTransformer($arr));
        } else {
            return $this->errorResponse(404, '请求的资源不存在');
        }
    }

    /**
     * @DELETE
     * 门店删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $shop_id = $request->input('id');
        if (empty($shop_id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $res = $this->shop->destroy($shop_id, $merchant_id);
        if ($res) {
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(404, '请求的资源不存在');
        }
    }

    /**
     * @GET
     * 获取门店名称列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function getShopList()
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $arr = $this->shop->getShopList($merchant_id);
        if ($arr) {
            return $this->successResponse(200, '成功', $arr);
        } else {
            return $this->errorResponse(204, '暂无数据');
        }
    }

    /**
     * 获取商户还能添加的门店数量
     * @GET
     * @return \Illuminate\Http\JsonResponse
     */
    public function getShopNum()
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $shop_num = DB::table('wr_merchant')
            ->where('id', $merchant_id)
            ->value('shop_nums');
        //获取已经存在的门店
        $shop_count = DB::table('wr_shop')
            ->where('merchant_id', $merchant_id)
            ->where('deleted_at',NULL)
            ->count();
        $add_num = $shop_num-$shop_count;
        return $this->successResponse(200, '成功', $add_num);
    }
    
    
    /**
     * 获取公众号的原始id
     * @param $merchant_id
     * @return mixed
     */
    public function _getWxToken($merchant_id)
    {
        return $token = DB::table('wr_merchant')
            ->join('wr_public', 'wr_public.id', '=', 'wr_merchant.public_id')
            ->where('wr_merchant.id', $merchant_id)
            ->value('token');
    }

}