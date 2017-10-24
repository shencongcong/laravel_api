<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:21
 */

namespace App\Api\Controllers\Merchant;

use App\Api\Controllers\ApiBaseController;
use App\Api\Transformer\WaiterTransformer;
use Illuminate\Http\Request;
use App\Repositories\Contracts\WaiterRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class WaiterController
 * @package App\Api\Controllers
 */
class WaiterController extends ApiBaseController
{
    protected $WaiterTransformer;
    private $waiter;

    public function __construct(WaiterRepository $waiterRepository, WaiterTransformer $waiterTransformer)
    {
        $this->waiter = $waiterRepository;
        $this->WaiterTransformer = $waiterTransformer;
    }

    /**
     * @GET
     * 所有服务师
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $waiter = $this->waiter->index($merchant_id);
        if ($waiter && $waiter !== 204 && $waiter !== 406) {
            return $this->successResponse(200, '成功', $waiter);
        } elseif ($waiter == 204) {
            return $this->errorResponse(204, '暂无服务师');
        } else {
            return $this->errorResponse(406, '数据异常');
        }
    }

    /**
     * @GET
     * 服务师展示
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $waiter_id = $request->input('id');   //服务师的id
        if (empty($waiter_id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $waiter = $this->waiter->show($waiter_id);
        if ($waiter && $waiter !== 204 && $waiter !== 406) {
            switch ($waiter['sex']) {
                case 1:
                    $waiter['sex'] = '男';
                    break;
                case 2:
                    $waiter['sex'] = '女';
                    break;
            }
            //获取服务师的产品
            $waiter_goods = DB::table('wr_waiter_goods')
                ->join('wr_goods_cate', 'wr_goods_cate.id', '=', 'wr_waiter_goods.goods_id')
                ->where('wr_waiter_goods.waiter_id', $waiter_id)
                ->select('wr_goods_cate.goods_name')
                ->get();
            $goods_name = array();
            foreach ($waiter_goods as $k => $value) {
                $goods_name[$k] = $value->goods_name;
            }
            $waiter['goods'] = $goods_name;
            $waiter_grade = DB::table('wr_waiter_comment')
                ->where('waiter_id', $waiter_id)
                ->where('deleted_at', null)
                ->avg('waiter_grade');
            $waiter['waiter_grade'] = round($waiter_grade,1);
            $comment = DB::table('wr_waiter_comment')
                ->where('waiter_id', $waiter_id)
                ->where('deleted_at', null)
                ->select('punctual_id', 'art_id', 'stance_id')
                ->get();
            if(count($comment)!==0){
                $punctual_arr = array();
                $art_arr = array();
                $stance_arr = array();
                foreach ($comment as $k => $v) {
                    $punctual_arr[$k] = $v->punctual_id;
                    $art_arr[$k] = $v->art_id;
                    $stance_arr[$k] = $v->stance_id;
                }
                //判断值相同的次数
                $punctual_num =array_count_values($punctual_arr);
                $art_num = array_count_values($art_arr);
                $stance_num = array_count_values($stance_arr);
                //获取最大值
                $punctual_max=array_search(max($punctual_num),$punctual_num);
                $art_max=array_search(max($art_num),$art_num);
                $stance_max=array_search(max($stance_num),$stance_num);
                $waiter['comment'] = array(
                    array('max'=>$stance_max),array('max'=>$art_max),array('max'=>$punctual_max)
                );
            }else{
                $waiter['comment'] = array(
                    array('max'=>''),array('max'=>''),array('max'=>'')
                );
            }
            return $this->successResponse(200, '成功', $waiter);
        } else if ($waiter == 204) {
            return $this->errorResponse(204, '暂无数据');
        } else {
            return $this->errorResponse(406, '数据库异常');
        }
    }

    /**
     * @DELETE
     * 服务师删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $waiter_id = $request->input('id');
        if (empty($waiter_id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $res = $this->waiter->destroy($waiter_id, $merchant_id);
        if ($res && $res !== 406) {

            return $this->successResponse(200, '成功');
        } else if ($res == 406) {
            return $this->errorResponse(406, '数据库异常');
        }else{
            return $this->errorResponse(404, '请求的资源不存在');
        }
    }

    /**
     * @POST
     * 根据店铺id 展示门店下的所有服务师
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function waiterByShop(Request $request)
    {
        $shop_id = $request->input('shop_id');
        if (empty($shop_id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
            $arr = $this->waiter->waiterByShop($shop_id);
            if($arr == 406){
                return $this->errorResponse(406, '数据库异常');
            }else{
                if(empty($arr))
                    return $this->errorResponse(204, '暂无数据');
                    return $this->successResponse(200, '成功', $arr);
            }
    }
}