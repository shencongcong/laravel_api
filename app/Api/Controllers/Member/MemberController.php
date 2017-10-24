<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:21
 */

namespace App\Api\Controllers\Member;

use App\Api\Controllers\ApiBaseController;
use App\Api\Transformer\MemberTransformer;
use App\Jobs\SendCode;
use App\Repositories\Contracts\MemberRepository;
use App\Repositories\Eloquent\ShopRepositoryEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Api\Controllers\Tool\SmsController as Sms;
use Cache;
use Config;
use Log;

/**
 * Class MemberController
 * @package App\Api\Controllers\Member
 */
class MemberController extends ApiBaseController
{
    /**
     * @var MemberTransformer
     */
    protected $memberTransformer;
    /**
     * @var MemberRepository
     */
    private $member;

    public function __construct(MemberRepository $memberRepository, MemberTransformer $memberTransformer)
    {
        $this->member = $memberRepository;
        $this->memberTransformer = $memberTransformer;
    }

    /**
     * @Post
     * 手机登录发送手机验证码
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
        $id = DB::table('wr_member')
            ->where('tel', $arr['tel'])
            ->where('deleted_at', NULL)
            ->where('status', 1)
            ->value('id');
        if ($id) {
            //获取验证码
            $code = $sms->code();
            $product = '客户登录';
            $tel = $arr['tel'];
            $job = (new SendCode($tel, $code, $product));
            $this->dispatch($job);
            Cache::put('member' . $tel, $code, Config::get('constants.TIME_EXPIRES'));
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(404, '手机号码不存在或者客户被禁用');
        }
    }

    /**
     * @POST
     * 根据手机号码获取商户信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function merchantByTel(Request $request)
    {
        $arr = $request->all();
        if (empty($arr['tel']) || empty($arr['code'])) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        //获取验证码
        $getCode = Cache::get('member' . $arr['tel']);
        if ($arr['code'] != $getCode) {
            return $this->errorResponse(407, '验证码错误');
        }
        //根据电话获取商户id
        $member = $this->member->indexByTel($arr['tel']);
        //dd($member);
        //判断服务师 是否是多个商户
        if (count($member) >= 2) {
            $array['merchant_type'] = 2;
            $array['tel'] = $arr['tel'];
            return $this->successResponse(200, '成功', $array);
        } elseif (count($member) == 1) {
            //单个商户
            $array['merchant_type'] = 1;
            $array['merchant_id'] = $member[0]['merchant_id'];
            $array['member_id'] = $member[0]['id'];
            return $this->successResponse(200, '成功', $array);

        } else {
            return $this->errorResponse(404, '请求的资源不存在');
        }
    }


    /**
     * 多店铺--选择店铺登录
     * @POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function chooseShopLogin(Request $request)
    {
        $member_id = $request->input('member_id');
        $merchant_id = $request->input('merchant_id');
        $shop_id = $request->input('shop_id');
        if (empty($shop_id) || empty($merchant_id) || empty($member_id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $merchant = DB::table('wr_member')
            ->where('id', $member_id)
            ->value('merchant_id');
        if ($merchant_id != $merchant) {
            return $this->errorResponse(407, '数据校验错误');
        } else {
            $arr = [
                'data' => [
                    'type' => Config::get('constants.MEMBER_LOGIN'),//服务师登录
                    'merchant_id' => $merchant_id,
                    'id' => $member_id,
                    'shop_id' => $shop_id
                ]
            ];
            $token = $this->createToken($arr);
            $array = [
                'token' => $token,
            ];
            return $this->successResponse(200, '成功', $array);
        }

    }

    /**
     * 单商户单门店直接登录,多店铺返回店铺id
     * @POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function chooseMerchantLogin(Request $request)
    {
        $merchant_id = $request->input('merchant_id');
        $member_id = $request->input('member_id');
        $shop_id = DB::table('wr_shop')
            ->where(['merchant_id' => $merchant_id, 'deleted_at' => null])
            ->pluck('id');
        if (count($shop_id) > 1) {
            //多店铺
            $array['member_id'] = $member_id;
            $array['shop_id'] = $shop_id;
            $array['shop_type'] = 2;
            return $this->successResponse(200, '成功', $array);
        } elseif (count($shop_id) == 1) {
            //单店铺
            $arr = [
                'data' => [
                    'type' => Config::get('constants.MEMBER_LOGIN'),//服务师登录
                    'merchant_id' => $merchant_id,
                    'id' => $member_id,
                    'shop_id' => $shop_id[0]
                ]
            ];
            $token = $this->createToken($arr);
            $array = [
                'token' => $token,
                //单个店铺状态判断
                'shop_type' => 1,
            ];
            return $this->successResponse(200, '成功', $array);
        } else {
            return $this->errorResponse(404, '请求的资源不存在');
        }
    }

    /**
     * @POST
     * 商户列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function merchantList(Request $request)
    {
        $arr = $this->dealRequest($request->all());
        if (empty($arr['tel'])) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $merchant = DB::table('wr_member')
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
                    $attr[$k]['member_id'] = DB::table('wr_member')
                        ->where('tel', $arr['tel'])
                        ->where('merchant_id', $v)
                        ->value('id');
                }
            }
            return $this->successResponse(200, '成功', $attr);
        } else {
            return $this->errorResponse(404, '请求的资源不存在');
        }
    }

    /**
     * @POST
     * 微信登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function wxLogin(Request $request)
    {
        $open_id = $this->dealStr($request->input('open_id'));
        if (empty($open_id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        //根据open_id获取商户id
        $member = $this->member->memberByOpenId($open_id);
        //return $member;
        //判断服务师 是否是多个商户
        if (count($member) > 1 && $member !== false) {
            $array['merchant_type'] = 2;
            $array['open_id'] = $open_id;
            return $this->successResponse(200, '成功', $array);
        } elseif (count($member) == 1 && $member !== false) {
            //单个商户
            $array['merchant_type'] = 1;
            $array['merchant_id'] = $member[0]['merchant_id'];
            $array['member_id'] = $member[0]['id'];
            return $this->successResponse(200, '成功', $array);
        } else {
            return $this->errorResponse(404, '请求的资源不存在');
        }
    }

    /**
     * @POST
     * 微信登录--多商户列表展示
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function wxMerchantList(Request $request)
    {
        $open_id = $this->dealStr($request->input('open_id'));
        if (empty($open_id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $merchant = DB::table('wr_member')
            ->where('open_id', $open_id)
            ->where(['status' => 1, 'deleted_at' => NULL])
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
                    $attr[$k]['member_id'] = DB::table('wr_member')
                        ->where('merchant_id', $v)
                        ->where('deleted_at', NULL)
                        ->where('open_id', $open_id)
                        ->value('id');
                }
            }
            return $this->successResponse(200, '成功', $attr);
        } else {
            return $this->errorResponse(404, '请求的资源不存在');
        }
    }

    /**
     * @GET
     * 客户登录之后，检查是否绑定手机号码
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkTelByToken()
    {
        $member_id = $this->getMesByToken()['id'];
        $member_tel = $this->member->checkTelByMemberId($member_id);
        if ($member_tel) {
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(404, '手机号码不存在');
        }
    }

    /**
     * @POST
     * 没有绑定手机号码，发送短信验证码
     * @param Request $request
     * @param Sms $sms
     * @return \Illuminate\Http\JsonResponse
     */
    public function bindTelSendMsg(Request $request, Sms $sms)
    {
        $tel = $this->dealStr($request->input('tel'));
        if (empty($tel)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        //获取验证码
        $code = $sms->code();
        Log::info('bindTelSendMsg' . $tel . '||' . $code);
        $product = '手机绑定';
        // 发送短信验证码放入队列中
        $job = (new SendCode($tel, $code, $product));
        $this->dispatch($job);
        Cache::put('memberBindTel' . $tel, $code, Config::get('constants.TIME_EXPIRES'));
        return $this->successResponse(200, '成功');
    }


    /**
     * @POST
     * 验证手机验证码，完成手机号码绑定
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bindTel(Request $request)
    {
        $member_id = $this->getMesByToken()['id'];
        $tel = $this->dealStr($request->input('tel'));
        $code = $this->dealStr($request->input('code'));
        if (empty($tel) || empty($code)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        //获取验证码
        $getCode = Cache::get('memberBindTel' . $tel);
        if ($code != $getCode) {
            return $this->errorResponse(407, '验证码错误');
        } else {
            $arr = array('tel' => $tel);
            $res = $this->member->bindTel($member_id, $arr);
            if ($res) {
                Cache::forget('memberBindTel' . $tel);
                return $this->successResponse(200, '成功');
            } else {
                //token失效
                $this->logoutToken();
                return $this->errorResponse(406, '失败');
            }
        }

    }

    /**
     * @GET
     * 客户退出
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
     * 客户端 我的首页展示
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $member_id = $this->getMesByToken()['id'];
        $member = $this->member->index($member_id);
        if ($member) {
            return $this->successResponse(200, '成功', $this->memberTransformer->indexTransformer($member));
        } else {
            return $this->errorResponse(406, '失败');
        }
    }

    /**
     * @GET
     * 客户信息编辑
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit()
    {
        $member_id = $this->getMesByToken()['id'];
        $member = $this->member->index($member_id);
        if ($member) {
            return $this->successResponse(200, '成功', $this->memberTransformer->editTransformer($member));
        } else {
            return $this->errorResponse(406, '失败');
        }

    }

    /**
     * @POST
     * 客户信息更新
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $member_id = $this->getMesByToken()['id'];
        $arr = $this->dealRequest($request->all());
        if (empty($arr['img']) || empty($arr['member_name'])) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $res = $this->member->memberUpdate($member_id, $arr);
        if ($res) {
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(406, '失败');
        }
    }

    /**
     * @POST
     * 删除商户 商户和会员关系
     */
    public function delMerchantRelation(Request $request)
    {
        $member_id = $this->dealStr($request->input('member_id'));
        $time_stamp = $this->dealStr($request->input('time_stamp'));
        $token = $this->dealStr($request->input('token'));
        if (empty($member_id) || empty($time_stamp) || empty($token)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $time = time();
        if ($time - $time_stamp > 600) {
            return $this->errorResponse(401, '时间过期');
        }
        $str = Config('constants.SIGNATURES_KEY');
        Log::info($member_id . "||" . $time_stamp . "||" . $str);
        $get_signature = token($member_id, $time_stamp, $str);
        Log::info('token' . $token);
        Log::info('signature' . $get_signature);
        if ($get_signature !== $token) {
            return $this->errorResponse(401, '没有权限');
        }
        $res = DB::table('wr_member')->where(['id' => $member_id])->delete();
        if ($res) {
            return $this->successResponse(200, '成功');
        } else {
            return $this->successResponse(200, '成功');
        }
    }

}