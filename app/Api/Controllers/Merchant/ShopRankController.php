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

/**
 * Class ShopRankController
 * @package App\Api\Controllers
 */
class ShopRankController extends ApiBaseController
{
    private $shop;
    protected $shopTransformer;

    public function __construct(ShopRepository $shopRepository, ShopTransformer $shopTransformer)
    {
        $this->shop = $shopRepository;
        $this->shopTransformer = $shopTransformer;
    }

    /**
     * 门店排行
     * @GET
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $time_logo = $request->input('time_logo');
        $merchant_id = $this->getMesByToken()['merchant_id'];

        if (empty($time_logo)) {
            return $this->errorResponse(405, '缺少必要参数');
        }
        switch ($time_logo) {
            case 1:
                //今天
                $time_arr = array(
                    strtotime(date('Y-m-d 0:0:0')),
                    strtotime(date('Y-m-d 23:59:59'))
                );
                break;
            case 2:
                //本月
                $time_arr = array(
                    mktime(0, 0, 0, date('m'), 1, date('Y')),
                    mktime(23, 59, 59, date('m'), date('t'), date('Y'))
                );
                break;
            case 3:
                //上月
                $m = date('Y-m-d', mktime(0, 0, 0, date('m') - 1, 1, date('Y'))); //上个月的开始日期
                $t = date('t', strtotime($m)); //上个月共多少天
                $time_arr = array(
                    mktime(0, 0, 0, date('m') - 1, 1, date('Y')),
                    mktime(0, 0, 0, date('m') - 1, $t, date('Y'))
                );
                break;
        }
        $attr = array();
        $shop_arr = $this->shop->index($merchant_id);
        if (count($shop_arr) !== 0) {
            foreach ($shop_arr as $k => $v) {
                $attr[$k]['img0'] = $v['img0'];
                $attr[$k]['shop_name'] = $v['shop_name'];
                $attr[$k]['waiter_num'] = DB::table('wr_shop_waiter')
                    ->join('wr_waiter', 'wr_waiter.id', '=', 'wr_shop_waiter.waiter_id')
                    ->where('wr_shop_waiter.shop_id', $v['id'])
                    ->where('wr_waiter.deleted_at', NULL)
                    ->count();
                $attr[$k]['appoint_num'] = DB::table('wr_appoint')
                    ->where('shop_id', $v['id'])
                    ->where('merchant_id',$merchant_id)
                    ->where('status', 2)
                    ->where('reason', 0)
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
            return $this->successResponse(200, '成功', $attr);
        } else {
            return $this->errorResponse(204, '暂无数据');
        }

    }

}