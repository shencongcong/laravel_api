<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:21
 */

namespace App\Api\Controllers\Merchant;

use App\Api\Controllers\ApiBaseController;
use Illuminate\Http\Request;
use App\Repositories\Contracts\MerchantAddressRepository;
use App\Jobs\SendReminderEmail;
use Illuminate\Support\Facades\DB;

/**
 * Class MerchantAddressController
 * @package App\Api\Controllers
 */
class AddressController extends ApiBaseController
{
    private $address;

    public function __construct(MerchantAddressRepository $merchantAddressRepository)
    {
        $this->address = $merchantAddressRepository;
    }

    /**
     * 商户二维码申请地址填写
     * @POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $arr = $this->dealRequest($request->all());
        if (empty($arr) || empty($arr['tel'] || empty($arr['address']) || empty($arr['name']))) {
            return $this->errorResponse(405, '缺少必要参数');
        }
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $merchant_name = DB::table('wr_merchant')
            ->where('id', $merchant_id)
            ->value('merchant_name');
        $address = $this->address->index($merchant_id);
        if ($address !== 204 && $address !== 406 && $address !== 4015) {
            $apply_num = $address['apply_num'];
            if ($apply_num >= 3) {
                return $this->errorResponse(4013, '您提交的申请已经超过3次');
            } else {
                //提交未超过3次，可以提交申请
                $arr['apply_num'] = $address['apply_num'] + 1;
                $res = $this->address->againStore($address['id'], $arr);
                if ($res == true && $res !== 406) {
                    //发送邮件提醒
                    $to = '1343948033@qq.com';
                    $to2 = 'ythou@weerun.com';
                    $subject = '商户二维码贴纸申请地址修改';
                    $title = '商户：' . $merchant_name . '的二维码贴纸申请地址信息已修改，请及时联系商户确认，并登录后台审核！';
                    $job1 = (new SendReminderEmail($to, $title, $subject));
                    $job2 = (new SendReminderEmail($to2, $title, $subject));
                    $this->dispatch($job1);
                    $this->dispatch($job2);
                    return $this->successResponse(200, '成功');
                } elseif ($res == false) {
                    return $this->errorResponse(400, '修改数据失败');
                } elseif ($res == 406) {
                    return $this->errorResponse(406, '数据库异常');
                }
            }
        } elseif ($address == 4015) {
            return $this->errorResponse(4015, '您提交的申请已经寄送中');
        } elseif ($address == 204) {
            //商户未申请，可以提交申请
            $arr['apply_num'] = 1;
            $arr['merchant_id'] = $merchant_id;
            $res = $this->address->store($arr);
            if ($res == true) {
                //发送邮件提醒
                $to = '1343948033@qq.com';
                $to2 = 'ythou@weerun.com';
                $subject = '商户二维码贴纸申请';
                $title = '商户：' . $merchant_name . '的二维码贴纸申请地址信息已提交，请登录后台审核！';
                $job1 = (new SendReminderEmail($to, $title, $subject));
                $job2 = (new SendReminderEmail($to2, $title, $subject));
                $this->dispatch($job1);
                $this->dispatch($job2);
                return $this->successResponse(200, '成功');
            } elseif ($res == false) {
                return $this->errorResponse(400, '修改数据失败');
            } else {
                return $this->errorResponse(406, '数据库异常');
            }
        } else {
            return $this->errorResponse(406, '数据库异常');
        }
    }

}