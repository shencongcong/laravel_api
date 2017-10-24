<?php

namespace App\Api\Controllers\Merchant;

use App\Api\Controllers\ApiBaseController;
use App\Api\Transformer\MerchantAdminTransformer;
use App\Jobs\SendCode;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\Repositories\Contracts\MerchantAdminRepository;
use DB;
use App\Api\Controllers\Tool\SmsController as Sms;
use Cache;

/**
 * Class MerchantAdminController
 * @package App\Api\Controllers
 */
class MerchantAdminController extends ApiBaseController
{
    /**
     * @var MerchantAdminRepository
     */
    private $merchantAdmin;
    protected $adminTransformer;


    public function __construct(MerchantAdminRepository $merchantAdminRepository, MerchantAdminTransformer $adminTransformer)
    {
        $this->merchantAdmin = $merchantAdminRepository;
        $this->adminTransformer = $adminTransformer;
    }

    /**
     * @POST
     * 商户登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $attr = $this->dealRequest($request->all());
        $admin_tel = $attr['admin_tel'];
        $admin_password = $attr['admin_password'];
        if(empty($admin_tel)||empty($admin_password)){
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        //获取商户id
        $merchant_admin_arr = $this->merchantAdmin->checkLogin($admin_tel, $admin_password);
        if ($merchant_admin_arr) {
            $merchant_id = DB::table('wr_merchant')
                ->where('id',$merchant_admin_arr['merchant_id'])
                ->where('status',1)
                ->value('id');
            if($merchant_id){
                $arr = [
                    'data' => [
                        'type' => Config::get('constants.MERCHANT_LOGIN'),
                        'merchant_id' => $merchant_id,
                        'id' => $merchant_admin_arr['id'],
                    ]
                ];
                $token = $this->createToken($arr);
                $array = [
                    'token' => $token,
                ];
                return $this->successResponse(200, '成功', $array);
            }else{
                return $this->errorResponse(4002, '商户审核中！');
                //return $this->errorResponse(404, '商户审核中！');
            }
        } else {
            return $this->errorResponse(4001, '用户名或密码错误');
            //return $this->errorResponse(407, '用户名或密码错误');
        }
    }

    /**
     * @GET
     * 商户管理员登录商户首页
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //商户管理员的id
        $id = $this->getMesByToken()['id'];
        $admin = $this->merchantAdmin->index($id);
        if ($admin) {
            $attr = array();
            //获取商户头像
            $merchant =DB::table('wr_merchant')
                ->where('id',$admin['merchant_id'])
                ->select('logo','merchant_name','introduce')
                ->first();
            $attr['img'] = $merchant->logo;
            $attr['nickname'] = $merchant->merchant_name;
            $attr['introduce'] = $merchant->introduce;
            return $this->successResponse(200, '成功', $attr);
        } else {
            return $this->errorResponse(404, '请求的资源不存在');
        }
    }

    /**
     * @GET
     * 商户信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        //商户管理员的id
        $id = $this->getMesByToken()['id'];
        $admin = $this->merchantAdmin->index($id);
        if ($admin) {
            $attr = array();
            //获取商户头像
            $merchant =DB::table('wr_merchant')
                ->where('id',$admin['merchant_id'])
                ->select('logo','merchant_name','introduce')
                ->first();
            $attr['img'] = $merchant->logo;
            $attr['nickname'] = $merchant->merchant_name;
            $attr['introduce'] = $merchant->introduce;
            return $this->successResponse(200, '成功',$attr);
        } else {
            return $this->errorResponse(404, '请求的资源不存在');
        }
    }

    /**
     * @POST
     * 商户信息修改
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $id = $this->getMesByToken()['id'];
        $attr = $this->dealRequest($request->only('nickname', 'img','introduce'));
        if (empty($attr['nickname']) || empty($attr['img'])) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $merchant_id = DB::table('wr_merchant_admin')
            ->where('id',$id)
            ->value('merchant_id');
        $arr['logo'] = $attr['img'];
        $arr['merchant_name'] = $attr['nickname'];
        $arr['introduce'] = $attr['introduce'];
        $res = DB::table('wr_merchant')
            ->where('id',$merchant_id)
            ->update($arr);
        //$res = $this->merchantAdmin->merchantAdminUpdate($attr, $id);
        if ($res) {
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(400, '修改数据失败');
        }
    }

    /**
     * @POST
     * 商户管理员的密码修改
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pwdUpdate(Request $request)
    {
        //获取原密码，通过原密码校验
        $attr = $this->dealRequest($request->all());
        if (empty($attr['admin_tel']) || empty($attr['old_password']) || empty($attr['new_password'])) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $admin_tel = $attr['admin_tel'];
        $old_password = $attr['old_password'];
        $new_password = $attr['new_password'];
        $id = $this->getMesByToken()['id'];
        //校验密码是否正确
        $merchant_admin_arr= $this->merchantAdmin->checkLogin($admin_tel, $old_password);
        if ($merchant_admin_arr['id'] != $id){
            return $this->successResponse(407, '原密码错误');
        }
        $res = $this->merchantAdmin->updatePsw(array('admin_password' => bcrypt($new_password)), $id);
        if ($res) {
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(406, '失败');
        }
    }

    /**
     * @GET
     * 商户退出
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
     * 管理员登录账号展示
     * @return \Illuminate\Http\JsonResponse
     */
    public function showName()
    {
        //商户管理员的id
        $id = $this->getMesByToken()['id'];
        $res = $this->merchantAdmin->showTel($id);
        if ($res) {
            return $this->successResponse(200, '成功', $res);
        } else {
            return $this->errorResponse(408, '失败');
        }
    }


    /**@POST
     * 忘记密码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgetPwd(Request $request)
    {
        $arr = $this->dealRequest($request->all());
        if (empty($arr['code'] || empty($arr['tel']))) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        //获取验证码
        $getCode = Cache::get('merchantAdmin' . $arr['tel']);
        if (($arr['code'] !== $getCode) || empty($getCode)) {
            return $this->errorResponse(407, '验证码错误');
        }
        $res = DB::table('wr_merchant_admin')
            ->where('admin_tel', $arr['tel'])
            ->select('id', 'merchant_id')
            ->first();
        Cache::forget('merchantAdmin' . $arr['tel']);
        if ($res) {
            $id = $res->id;
            $merchant_id = $res->merchant_id;
            $arr = [
                'data' => [
                    'type' => Config::get('constants.MERCHANT_LOGIN'),
                    'merchant_id' => $merchant_id,
                    'id' => $id,
                ]
            ];
            $token = $this->createToken($arr);
            $array = [
                'token' => $token,
            ];

            return $this->successResponse(200, '成功', $array);
        } else {
            return $this->errorResponse(404, '登录手机号码不存在');
        }
    }

    /**@POST
     * 忘记密码之修改密码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgetPwdUpdatePwd(Request $request)
    {
        $arr = $this->dealRequest($request->all());
        $id = $this->getMesByToken()['id'];
        if (empty($arr['admin_password'])) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        //token失效
        $res = $this->logoutToken();
        if ($res) {
            $attr['admin_password'] = bcrypt($arr['admin_password']);
            $res = $this->merchantAdmin->forgetPwdUpdatePwd($id, $attr);
            if ($res) {
                return $this->successResponse(200, '成功');
            } else {
                return $this->errorResponse(404, '失败');
            }
        } else {
            return $this->errorResponse(408, '系统错误');
        }
    }

    /**
     * @POST
     * 忘记密码 发送短信验证码
     * @param Request $request
     * @param Sms $sms
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendSms(Request $request, Sms $sms)
    {
        $tel = $this->dealStr($request->input('tel'));
        if (empty($tel)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $id = DB::table('wr_merchant_admin')
            ->where('admin_tel', $tel)
            ->value('id');
        if ($id) {
            //获取验证码
            $code = $sms->code();
            $product = '忘记密码';
            // 发送短信验证码放入队列中
            $job = (new SendCode($tel,$code,$product));
            $this->dispatch($job);
            Cache::put('merchantAdmin' . $tel, $code, Config::get('constants.FIVE_MINUTE'));
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(4004, '手机号码不存在');
        }
    }
    
}