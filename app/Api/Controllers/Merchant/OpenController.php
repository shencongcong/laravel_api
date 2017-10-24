<?php

namespace App\Api\Controllers\Merchant;

use App\Api\Controllers\ApiBaseController;
use App\Jobs\SendReminderEmail;
use App\Models\Merchant;
use App\Models\MerchantAdmin;
use App\models\Waiter;
use App\Repositories\Eloquent\WaiterRepositoryEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\Eloquent\GoodsCateRepositoryEloquent;
use Cache;
use App\Jobs\SendCode;
use App\Api\Controllers\Tool\SmsController as Sms;

/**
 * Class OpenController
 * @package App\Api\Controllers\Merchant
 */
class OpenController extends ApiBaseController
{

    /**
     * 检查服务师是否已经注册
     * @POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkWaiterRegister(Request $request)
    {
        $token = $this->dealStr($request->input('token'));
        $merchant_id = $this->dealStr($request->input('merchant_id'));
        $open_id = $this->dealStr($request->input('open_id'));
        //签名验证
        $str = Config('constants.SIGNATURES_KEY');
        $get_signature = signature($open_id, $str, $merchant_id);
        if ($token != $get_signature) {
            return $this->errorResponse(401, '没有权限');
        }
        if (empty($merchant_id) || empty($open_id) || empty($token)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        //检查是否已注册
        $id = Waiter::where('open_id', $open_id)
            ->where('merchant_id', $merchant_id)
            ->value('id');
        if ($id) {
            return $this->errorResponse(201, '已注册');
        } else {
            return $this->successResponse(200, '成功');
        }

    }

    /**
     * 扫码服务师注册
     * @POST
     * @param Request $request
     * @param WaiterRepositoryEloquent $waiterRepositoryEloquent
     * @return \Illuminate\Http\JsonResponse
     */
    public function waiterRegister(Request $request, WaiterRepositoryEloquent $waiterRepositoryEloquent)
    {
        $all = $this->dealRequest($request->except('shop_id', 'goods_id', 'token'));
        $shop_id = $this->dealRequest($request->input('shop_id'));
        $goods_id = $this->dealRequest($request->input('goods_id'));
        $merchant_id = $all['merchant_id'];
        $open_id = $all['open_id'];
        $token = $this->dealStr($request->input('token'));
        $str = Config('constants.SIGNATURES_KEY');
        //签名验证
        $get_signature = signature($open_id, $str, $merchant_id);
        if ($token !== $get_signature) {
            return $this->errorResponse(401, '没有权限');
        }

        if (empty($all) || empty($shop_id) || empty($goods_id)
            || empty($token) || empty($merchant_id) || empty($open_id) ||empty($all['tel'])
        ) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        if(!preg_match("/^1[34578]\d{9}$/", $all['tel'])){
            return $this->errorResponse(405, '手机号码错误');
        }
        //scc 判断手机号+ 商户是否存在
        $res = DB::table('wr_waiter')
            ->where(['tel'=>$all['tel'],'merchant_id'=>$merchant_id,'deleted_at'=>null])
            ->select('id')->get();
        if($res){
            //已经注册过了，直接返回成功
            return $this->successResponse(200, '成功');
        }
        //scc end
        $res = $waiterRepositoryEloquent->waiterRegister($all, $shop_id, $goods_id, $merchant_id,$open_id);
        if ($res) {
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(406, '失败');
        }

    }

    /**
     * 根据商户id展示所有的门店
     * @GET
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function shopIndex(Request $request)
    {
        $merchant_id = $request->input('merchant_id');
        if (empty($merchant_id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $shop = DB::table('wr_shop')
            ->where(['merchant_id' => $merchant_id, 'deleted_at' => null])
            ->select('id', 'shop_name')
            ->get();
        if ($shop) {
            return $this->successResponse(200, '成功', $shop);
        } else {
            return $this->errorResponse(404, '失败');
        }
    }

    /**
     * 根据商户id展示所有职位
     * @GET
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function levelIndex(Request $request)
    {
        $merchant_id = $request->input('merchant_id');
        if (empty($merchant_id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $level = DB::table('wr_waiter_level')
            ->where('merchant_id', $merchant_id)
            ->select('id', 'name')
            ->get();
        if ($level) {
            return $this->successResponse(200, '成功', $level);
        } else {
            return $this->errorResponse(404, '失败');
        }
    }

    /**
     * 根据商户id展示所有服务
     * @GET
     * @param Request $request
     * @param GoodsCateRepositoryEloquent $eloquent
     * @return \Illuminate\Http\JsonResponse
     */
    public function goodsIndex(Request $request, GoodsCateRepositoryEloquent $eloquent)
    {
        $merchant_id = $request->input('merchant_id');
        if (empty($merchant_id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $goods = $eloquent->index($merchant_id);
        if ($goods) {
            return $this->successResponse(200, '成功', $goods);
        } else {
            return $this->errorResponse(404, '失败');
        }
    }


    /**
     * 检查电话是否注册过商户
     * @POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function merchantRegisterCheckTel(Request $request)
    {
        $tel = $this->dealStr($request->input('tel'));
        $res = DB::table('wr_merchant_admin')
            ->where('admin_tel', $tel)
            ->value('id');
        if ($res) {
            return $this->errorResponse(201, '已注册');
        } else {
            return $this->successResponse(200, '可以注册');
        }
    }

    /**
     * 商户注册发送验证码
     * @POST
     * @param Request $request
     * @param Sms $sms
     * @return \Illuminate\Http\JsonResponse
     */
    public function merchantRegisterSendMsg(Request $request, Sms $sms)
    {
        $tel = $this->dealStr($request->input('tel'));
        if (empty($tel)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        //获取验证码
        $code = $sms->code();
        $product = '商户注册';
        // 发送短信验证码放入队列中
        $job = (new SendCode($tel, $code, $product));
        $this->dispatch($job);
        Cache::put('merchantRegister' . $tel, $code, Config('constants.FIVE_MINUTE'));
        return $this->successResponse(200, '成功');
    }

    /**
     * 检测手机验证码
     * @POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkMsgCode(Request $request)
    {
        $code = $this->dealStr($request->input('code'));
        $tel = $this->dealStr($request->input('tel'));
        if (empty($code) || empty($tel)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $get_code = Cache::get('merchantRegister' . $tel);
        if (($code != $get_code) || empty($get_code)) {
            return $this->errorResponse(407, '验证码错误');
        }
        Cache::forget('merchantRegister' . $tel);
        return $this->successResponse(200, '成功',$tel);
    }

    /**
     * 商户完成注册
     * @POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function merchantRegister(Request $request)
    {
        $token = $this->dealStr($request->input('token'));
        $tel = $this->dealStr($request->input('tel'));
        $time_stamp = $this->dealStr($request->input('time_stamp'));
        $merchant_name = $this->dealStr($request->input('merchant_name'));
        $shop_num = $this->dealStr($request->input('shop_num'));
        $logo = $this->dealStr($request->input('logo'));
        $password = $this->dealStr($request->input('password'));
        $introduce = $this->dealStr($request->input('introduce'));
        $time = time();
        if ($time-$time_stamp > 600) {
                return $this->errorResponse(401, '时间过期');
        }
        $str = Config('constants.SIGNATURES_KEY');
        $get_signature = token($tel,$time_stamp,$str);
        if ($get_signature !== $token || empty($token)) {
               return $this->errorResponse(401, '没有权限');
        }
        if(empty($tel) ||empty($merchant_name)||empty($shop_num)||empty($password))
        {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $res = DB::table('wr_merchant_admin')
            ->where('admin_tel', $tel)
            ->value('id');
        if ($res) {
            return $this->errorResponse(201, '已注册');
        }
        //商户默认到期日期
        $expire = strtotime(date('Y', $time) + Config('constants.MERCHANT_EXPIRE_TIME') . '-' . date('m-d H:i:s'));
        $merchant_arr['logo'] = $logo;
        $merchant_arr['introduce'] = $introduce;
        $merchant_arr['merchant_name'] = $merchant_name;
        $merchant_arr['shop_nums'] = $shop_num;
        $merchant_arr['role'] = Config('constants.BASE_ROLE');
        $merchant_arr['expire'] = $expire;
        //默认禁用，审核后可以使用
        $merchant_arr['status'] = 0;
        $merchant_admin['admin_tel'] = $tel;
        $merchant_admin['admin_password'] = bcrypt($password);

        DB::beginTransaction();
        try {
            $user1 = Merchant::create($merchant_arr);
            if ($user1) {
                $merchant_admin['merchant_id'] = $user1->id;
                $user2 = MerchantAdmin::create($merchant_admin);
                if ($user1 && $user2) {
                    DB::commit();
                    // 商户申请信息提交后，发送短信通知我们
                    $to = '1343948033@qq.com';
                    $to2 = 'ythou@weerun.com';
                    $subject = '商户入驻申请';
                    $title= '商户：'.$merchant_name.'的申请信息已提交，请登录后台审核！';
                    $job1 = (new SendReminderEmail($to,$title,$subject));
                    $job2 = (new SendReminderEmail($to2,$title,$subject));
                    $this->dispatch($job1);
                    $this->dispatch($job2);
                    return $this->successResponse(200, '成功');
                }
            } else {
                DB::rollBack();
                return $this->errorResponse(406, '失败');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(406, '失败');
        }
    }

}