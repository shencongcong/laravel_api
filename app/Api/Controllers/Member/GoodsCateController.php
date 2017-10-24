<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:21
 */

namespace App\Api\Controllers\Member;

use App\Api\Controllers\ApiBaseController;
use App\Api\Transformer\GoodsCateTransformer;
use Illuminate\Http\Request;
use App\Repositories\Contracts\GoodsCateRepository;
use Illuminate\Support\Facades\DB;


/**
 * Class GoodsCateController
 * @package App\Api\Controllers\Member
 */
class GoodsCateController extends ApiBaseController
{
    private $goods_cate;
    protected $goodsCateTransformer;

    public function __construct(GoodsCateRepository $cateRepository, GoodsCateTransformer $transformer)
    {
        $this->goods_cate = $cateRepository;
        $this->goodsCateTransformer = $transformer;
    }

    /**
     * 获取所有的服务产品大类
     * @GET
     * @return \Illuminate\Http\JsonResponse
     */
    public function allParent()
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $parent_goods = $this->goods_cate->allParent($merchant_id);
        if ($parent_goods) {
            return $this->successResponse(200, '成功', $parent_goods);
        } else {
            return $this->errorResponse(204, '暂无数据');
        }
    }

    /**
     * 获取所有的产品子类（根据大类排列）
     * @GET
     * @return \Illuminate\Http\JsonResponse
     */
    public function allChild()
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $child_goods = $this->goods_cate->allChild($merchant_id);
        if ($child_goods) {
            return $this->successResponse(200, '成功', $child_goods);
        } else {
            return $this->errorResponse(204, '暂无数据');
        }
    }

    /**
     * 根据大类id获取子类
     * @GET
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function goodsCateByPid(Request $request)
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $pid = $request->input('pid');
        if(empty($pid)){
            return $this->errorResponse(405,'请求缺少必要参数');
        }
        $goods_cate = $this->goods_cate->goodsCateByPid($merchant_id,$pid);
        if($goods_cate){
            return $this->successResponse(200, '成功', $goods_cate);
        }else{
            return $this->errorResponse(204, '暂无数据');
        }
    }

    /**
     * 根据子类id获取项目数据（预约项目）
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function goodsCateById(Request $request)
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $goods_id = $request->input('id');
        if(empty($goods_id)){
            return $this->errorResponse(405,'请求缺少必要参数');
        }
        $goods_cate = $this->goods_cate->goodsCateById($merchant_id,$goods_id);
        if($goods_cate){
            return $this->successResponse(200, '成功', $goods_cate);
        }else{
            return $this->errorResponse(406, '数据库异常');
        }
    }

    /**
     * @POST
     * 根据服务师id获取 产品大类
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function parentByWaiterId(Request $request)
    {
        $waiter_id = $request->input('waiter_id');
        if(empty($waiter_id)){
            return $this->errorResponse(405,'请求缺少必要参数');
        }
        $parent_arr = $this->goods_cate->parentByWaiterId($waiter_id);
        if($parent_arr){
            return $this->successResponse(200, '成功', $parent_arr);
        }else{
            return $this->errorResponse(204, '暂无数据');
        }
    }

    /**
     * @POST
     * 据服务师id获取 所有的产品子类
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function goodsCateByWaiterId(Request $request)
    {
        $waiter_id = $request->input('waiter_id');
        if(empty($waiter_id)){
            return $this->errorResponse(405,'请求缺少必要参数');
        }
        $goods_arr = $this->goods_cate->goodsCateByWaiterId($waiter_id);
        if($goods_arr){
            return $this->successResponse(200, '成功', $goods_arr);
        }else{
            return $this->errorResponse(204, '暂无数据');
        }
    }

    /**
     * @POST
     * 根据服务师id,产品pid 获取产品子类
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function goodsCateByWaiterIdByPid(Request $request)
    {
        $waiter_id = $this->dealStr($request->input('waiter_id'));
        $pid = $this->dealStr($request->input('pid'));
        if(empty($waiter_id)||empty($waiter_id)){
            return $this->errorResponse(405,'请求缺少必要参数');
        }
        $goods_arr = $this->goods_cate->goodsCateByWaiterIdByPid($pid,$waiter_id);
        if($goods_arr){
            return $this->successResponse(200, '成功', $goods_arr);
        }else{
            return $this->errorResponse(204, '暂无数据');
        }
    }
}

