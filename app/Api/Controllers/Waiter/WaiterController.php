<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:21
 */

namespace App\Api\Controllers\Waiter;

use App\Api\Controllers\ApiBaseController;
use App\Api\Transformer\WaiterTransformer;
use App\Jobs\SendCode;
use App\models\Shop;
use App\models\Waiter;
use Illuminate\Http\Request;
use App\Repositories\Contracts\WaiterRepository;
use App\Repositories\Contracts\GoodsCateRepository;
use App\Repositories\Contracts\WaiterLevelRepository;
use Illuminate\Support\Facades\DB;
use App\Api\Controllers\Tool\SmsController as Sms;
use Illuminate\Support\Facades\Config;
use Cache;

/**
 * 服务师登录
 * Class WaiterController
 * @package App\Api\Controllers
 */
class WaiterController extends ApiBaseController
{
    /**
     * @var WaiterTransformer
     */
    protected $WaiterTransformer;
    /**
     * @var WaiterRepository
     */
    private $waiter;

    public function __construct(WaiterRepository $waiterRepository, WaiterTransformer $waiterTransformer)
    {
        $this->waiter = $waiterRepository;
        $this->WaiterTransformer = $waiterTransformer;
    }

    /**
     * @Post
     * 服务师登录发送手机验证码
     * @param Request $request
     * @param Sms $sms
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendSms(Request $request, Sms $sms)
    {
        $arr = $this->dealRequest($request->all());
        if (empty($arr['tel'])) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $id = Waiter::where('tel', $arr['tel'])
            ->value('id');
        if ($id) {
            //获取验证码
            $code = $sms->code();
            $product = '服务师登录';
            $tel = $arr['tel'];
            //$status_code = $sms->sendSms($tel, $code, $product);
            $job = (new SendCode($tel, $code, $product));
            $this->dispatch($job);
            Cache::put('waiter' . $tel, $code, Config::get('constants.TIME_EXPIRES'));
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(403, '不是服务师');
        }

    }

    /**
     * @POST
     * 服务师手机登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $arr = $request->all();
        if (empty($arr['tel']) || empty($arr['code'])) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        //获取验证码
        $getCode = Cache::get('waiter' . $arr['tel']);
        if ($arr['code'] != $getCode || empty($getCode)) {
            return $this->errorResponse(407, '验证码错误');
        }
        Cache::forget('waiter' . $arr['tel']);
        //根据电话展示服务师信息
        $waiter = $this->waiter->showByTel($arr['tel']);
        //判断服务师 是否是多个商户
        if (count($waiter) >= 2) {
            //多商户状态判断
            $merchant['type'] = 2;
            $merchant['tel'] = $arr['tel'];
            return $this->successResponse(200, '成功', $merchant);
        } elseif (count($waiter) == 1) {
            //dd($waiter);
            $arr = [
                'data' => [
                    'type' => Config::get('constants.WAITER_LOGIN'),//服务师登录
                    'merchant_id' => $waiter[0]['merchant_id'],
                    'id' => $waiter[0]['id'],
                ]
            ];
            $token = $this->createToken($arr);
            $array = [
                'token' => $token,
                //单个商户状态判断
                'type' => 1,
            ];
            return $this->successResponse(200, '成功', $array);
        } else {
            return $this->errorResponse(404, '请求的资源不存在');
        }
    }

    /**
     * @POST
     * 根据服务师tel获取商户列表（手机号码）
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function merchantList(Request $request)
    {
        $arr = $this->dealRequest($request->all());
        if (empty($arr['tel'])) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $merchant = DB::table('wr_waiter')
            ->where('tel', $arr['tel'])
            ->pluck('merchant_id');
        if ($merchant) {
            $attr = array();
            foreach ($merchant as $k => $v) {
                $merchant_arr = DB::table('wr_merchant')
                    ->where('id', $v)
                    ->select('merchant_name', 'logo')
                    ->first();
                if (empty($merchant_arr)) {
                    unset($merchant[$k]);
                } else {
                    $attr[$k]['merchant_name'] = $merchant_arr->merchant_name;
                    $attr[$k]['logo'] = $merchant_arr->logo;
                    $attr[$k]['merchant_id'] = $v;
                    $attr[$k]['tel'] = $arr['tel'];
                }
            }
            return $this->successResponse(200, '成功', $attr);
        } else {
            return $this->errorResponse(404, '请求的资源不存在');
        }

    }

    /**
     * @POST
     * 多商户下服务师登录（手机号码登录）
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function moreMerchantLogin(Request $request)
    {
        $arr = $this->dealRequest($request->all());
        if (empty($arr['tel']) || empty($arr['merchant_id'])) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $waiter_id = $this->waiter->getWaiterId($arr['merchant_id'], $arr['tel']);
        if ($waiter_id) {
            $attr = [
                'data' => [
                    'type' => Config::get('constants.WAITER_LOGIN'),//服务师登录
                    'merchant_id' => $arr['merchant_id'],
                    'id' => $waiter_id,
                ]
            ];
            $token = $this->createToken($attr);
            $array = [
                'token' => $token,
            ];
            return $this->successResponse(200, '成功', $array);
        } else {
            return $this->errorResponse(404, '请求的资源不存在');
        }

    }

    /**
     * 服务师微信登录
     * @POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function wxLogin(Request $request)
    {
        /*$time_stamp = $this->dealStr($request->input('time_stamp'));
        $token = $this->dealStr($request->input('token'));*/
        $open_id = $this->dealStr($request->input('open_id'));
        if (empty($open_id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        /*if (empty($open_id)||empty($time_stamp)||empty($token)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }*/
        /*$time = time();
        if($time-$time_stamp>600){
            return $this->errorResponse(401, '请求超时');
        }*/
        /*$get_token = token($open_id,$time_stamp,config('constants.SIGNATURES_KEY'));
        if($token!==$get_token){
            return $this->errorResponse(401, '效验错误');
        }*/
        //根据open_id展示服务师的商户信息
        $merchant_arr = $this->waiter->showByOpenId($open_id);
        //判断服务师 是否是多个商户
        if (count($merchant_arr) > 1 && $merchant_arr !== false) {
            //多商户状态判断
            $merchant['type'] = 2;
            $merchant['open_id'] = $open_id;
            return $this->successResponse(200, '成功', $merchant);
        } elseif (count($merchant_arr) == 1 && $merchant_arr !== false) {
            $arr = [
                'data' => [
                    'type' => Config::get('constants.WAITER_LOGIN'),//服务师登录
                    'merchant_id' => $merchant_arr[0]['merchant_id'],
                    'id' => $merchant_arr[0]['id'],
                ]
            ];
            $token = $this->createToken($arr);
            $array = [
                'token' => $token,
                //单个商户状态判断
                'type' => 1,
            ];
            return $this->successResponse(200, '成功', $array);
        } else {
            return $this->errorResponse(404, '请求的资源不存在');
        }
    }

    /**
     * @POST
     * 根据服务师微信OPEN_ID获取商户列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function wxMerchantList(Request $request)
    {
        $open_id = $this->dealStr($request->input('open_id'));
        if (empty($open_id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $merchant = DB::table('wr_waiter')
            ->join('wr_merchant','wr_merchant.id','=','wr_waiter.merchant_id')
            ->where('wr_waiter.open_id', $open_id)
            ->where('wr_waiter.deleted_at', NULL)
            ->pluck('merchant_id');
        if ($merchant) {
            $attr = array();
            foreach ($merchant as $k => $v) {
                $merchant_arr = DB::table('wr_merchant')
                    ->where('id', $v)
                    ->select('merchant_name', 'logo')
                    ->first();
                if (empty($merchant_arr)) {
                    unset($merchant[$k]);
                } else {
                    $attr[$k]['merchant_name'] = $merchant_arr->merchant_name;
                    $attr[$k]['logo'] = $merchant_arr->logo;
                    $attr[$k]['merchant_id'] = $v;
                    $attr[$k]['open_id'] = $open_id;
                }
            }
            return $this->successResponse(200, '成功', $attr);
        } else {
            return $this->errorResponse(404, '请求的资源不存在');
        }
    }

    /**
     * 多商户下服务师微信登录
     * @POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function wxMoreMerchantLogin(Request $request)
    {
        $arr = $this->dealRequest($request->all());
        if (empty($arr['open_id']) || empty($arr['merchant_id'])) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $waiter_id = $this->waiter->getWaiterIdByOpenId($arr['merchant_id'], $arr['open_id']);
        if ($waiter_id) {
            $attr = [
                'data' => [
                    'type' => Config::get('constants.WAITER_LOGIN'),//服务师登录
                    'merchant_id' => $arr['merchant_id'],
                    'id' => $waiter_id,
                ]
            ];
            $token = $this->createToken($attr);
            $array = [
                'token' => $token,
            ];
            return $this->successResponse(200, '成功', $array);
        } else {
            return $this->errorResponse(404, '请求的资源不存在');
        }

    }

    /**
     * @GET
     * 服务师退出
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $res = $this->logoutToken();
        if ($res) {
            return $this->successResponse(200, '退出成功');
        } else {
            return $this->errorResponse(408, '退出失败');
        }
    }

    /**
     * @GET
     * 服务师端首页
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $waiter_id = $this->getMesByToken()['id'];
        $waiter = $this->waiter->waiterShow($waiter_id);
        if ($waiter && $waiter !== 406) {
            return $this->successResponse(200, '成功', $this->WaiterTransformer->indexTransformer($waiter));
        } else if ($waiter == 406) {
            return $this->errorResponse(406, '数据库异常');
        } else {
            return $this->errorResponse(404, '数据不存在');
        }

    }

    /**
     * @GET
     * 服务师信息编辑
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit()
    {
        $waiter_id = $this->getMesByToken()['id'];
        $waiter = $this->waiter->waiterShow($waiter_id);
        if ($waiter && $waiter !== 406 && $waiter !== 404) {
            $waiter['shop_id'] = DB::table('wr_shop_waiter')
                ->join('wr_shop', 'wr_shop.id', '=', 'wr_shop_waiter.shop_id')
                ->where('wr_shop_waiter.waiter_id', $waiter_id)
                ->where('wr_shop_waiter.merchant_id', $waiter['merchant_id'])
                ->pluck('wr_shop.id');
            //获取服务师的产品
            $waiter_goods_id = DB::table('wr_waiter_goods')
                ->join('wr_goods_cate', 'wr_goods_cate.id', '=', 'wr_waiter_goods.goods_id')
                ->where('wr_waiter_goods.waiter_id', $waiter_id)
                ->pluck('wr_goods_cate.id');
            $waiter['goods_id'] = $waiter_goods_id;
            return $this->successResponse(200, '成功', $this->WaiterTransformer->editTransformer($waiter));
        } else if ($waiter == 406) {
            return $this->errorResponse(406, '数据库异常');
        } else {
            return $this->errorResponse(404, '数据不存在');
        }
    }

    /**
     * @POST
     * 服务师信息更新
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $id = $this->getMesByToken()['id'];
        $arr = $this->dealRequest($request->except('goods_id', 'shop_id'));
        $shop_id = $this->dealRequest($request->input('shop_id'));
        $goods_id = $this->dealRequest($request->input('goods_id'));
        if (empty($arr['img']) || empty($arr['sex']) || empty($arr['level']) || empty($goods_id)
            || empty($arr['work_length']) || empty($shop_id) || empty($arr['brief'])
        ) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $shop_arr = array();
        foreach ($shop_id as $k1 => $v1) {
            $shop_arr[$k1] = array(
                'waiter_id' => $id,
                'shop_id' => $v1,
                'merchant_id' => $merchant_id
            );
        }
        $goods_arr = array();
        foreach ($goods_id as $k => $v) {
            $goods_arr[$k] = array(
                'waiter_id' => $id,
                'goods_id' => $v
            );
        }
        $res = $this->waiter->waiterUpdate($id, $shop_arr, $goods_arr, $arr);
        if ($res) {
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(406, '失败');
        }

    }

    /**
     * @GET
     * 获取所有的门店信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function allShopByMerchant()
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $shop = Shop::where('merchant_id', $merchant_id)
            ->where('deleted_at',NULL)
            ->select('shop_name', 'id')
            ->get();
        if ($shop) {
            return $this->successResponse(200, '成功', $shop);
        } else {
            return $this->errorResponse(406, '失败');
        }

    }

    /**
     * 根据服务师id获取店铺信息
     * @GET
     * @return \Illuminate\Http\JsonResponse
     */
    public function shopByWaiterId()
    {
        $waiter_id = $this->getMesByToken()['id'];
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $shop_id = DB::table('wr_shop_waiter')
            ->where('waiter_id', $waiter_id)
            ->where('merchant_id', $merchant_id)
            ->pluck('shop_id');
        if ($shop_id) {
            $shop_arr = Shop::whereIn('id', $shop_id)
                ->select('shop_name', 'id')
                ->get();
            return $this->successResponse(200, '成功', $shop_arr);
        } else {
            return $this->errorResponse(404, '失败');
        }
    }

    /**
     * @GET
     * 获取所有的职位信息
     * @param WaiterLevelRepository $levelRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function allLevelByMerchant(WaiterLevelRepository $levelRepository)
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $level = $levelRepository->index($merchant_id);
        if ($level) {
            return $this->successResponse(200, '成功', $level);
        } else {
            return $this->errorResponse(406, '失败');
        }
    }

    /**
     * @GET
     * 获取所有的产品信息
     * @param GoodsCateRepository $goodsCateRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function allGoodsByMerchant(GoodsCateRepository $goodsCateRepository)
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $goods_cate = $goodsCateRepository->index($merchant_id);
        if ($goods_cate) {
            return $this->successResponse(200, '成功', $goods_cate);
        } else {
            return $this->errorResponse(406, '失败');
        }
    }
}