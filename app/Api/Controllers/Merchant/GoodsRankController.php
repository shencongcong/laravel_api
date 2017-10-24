<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:21
 */

namespace App\Api\Controllers\Merchant;

use App\Api\Controllers\ApiBaseController;
use App\Api\Transformer\GoodsCateTransformer;
use Illuminate\Http\Request;
use App\Repositories\Contracts\GoodsCateRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class AppointRankController
 * @package App\Api\Controllers
 */
class GoodsRankController extends ApiBaseController
{
    /**
     * @var GoodsCateRepository
     */
    private $goods;
    protected $goodsTransformer;

    public function __construct(GoodsCateRepository $goodsCateRepository, GoodsCateTransformer $cateTransformer)
    {
        $this->goods = $goodsCateRepository;
        $this->goodsTransformer = $cateTransformer;
    }

    /**
     * 产品预约排行
     * @GET
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $parent_id = $this->dealStr($request->input('parent_id'));
        if (empty($parent_id)) {
            return $this->errorResponse(405, '缺少必要参数');
        }
        //parent_id 为-1时表示所有的产品子类
        if ($parent_id == '-1') {
            $goods_arr = $this->goods->allChild($merchant_id);
        } else {
            //根据pid选择产品子类
            $goods_arr = $this->goods->goodsCateByPid($merchant_id,$parent_id);
        }
        if($goods_arr){
            $attr = array();
            foreach ($goods_arr as $k=>$v){
                $attr[$k]['id']= $v['id'];
                $attr[$k]['goods_name'] = $v['goods_name'];
                $attr[$k]['parent_name'] = $v['parent_name'];
                $attr[$k]['appoint_num'] = DB::table('wr_appoint')
                    ->where('goods_id', $v['id'])
                    ->where('merchant_id',$merchant_id)
                    ->where('status', 2)
                    ->where('reason', 0)
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
        }else{
            return $this->errorResponse(204, '暂无产品');
        }

    }

    /**
     * 所有的产品大类
     * @GET
     * @return \Illuminate\Http\JsonResponse
     */
    public function allGoodsParent()
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $parent_arr = $this->goods->allParent($merchant_id);
        if ($parent_arr) {
            return $this->successResponse(200, '成功', $parent_arr);
        } else {
            return $this->errorResponse(204, '暂无产品大类');
        }
    }
}