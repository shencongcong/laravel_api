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
 * Class GoodsCateController
 * @package App\Api\Controllers
 */
class GoodsCateController extends ApiBaseController
{
    /**
     * @var GoodsCateRepository
     */
    private $goods_cate;
    protected $cateTransformer;

    public function __construct(GoodsCateRepository $cateRepository, GoodsCateTransformer $cateTransformer)
    {
        $this->goods_cate = $cateRepository;
        $this->cateTransformer = $cateTransformer;
    }

    /**
     * @GET
     * 所有产品展示
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $goods_cate = $this->goods_cate->index($merchant_id);
        if ($goods_cate) {
            return $this->successResponse(200, '成功', $goods_cate);
        } else {
            return $this->errorResponse(204, '请求的资源不存在');
        }
    }

    /**
     * @POST
     * 添加 产品大类
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeParent(Request $request)
    {
        $arr = $request->input('goods_name');
        $merchant_id = $this->getMesByToken()['merchant_id'];
        if (empty($arr)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        //获取大类产品的最大排序
        $parent_sort = DB::table('wr_goods_cate')
            ->where('merchant_id', $merchant_id)
            ->where('level', 0)
            ->orderBy('sort', 'desc')
            ->value('sort');
        $attr = array();
        foreach ($arr as $k => $value) {
            $attr[$k]['goods_name'] = $value;
            $attr[$k]['sort'] = $parent_sort + $k + 1;
            $attr[$k]['pid'] = 0;
            $attr[$k]['merchant_id'] = $merchant_id;
            $attr[$k]['created_at'] = time();
            $attr[$k]['updated_at'] = time();
        }
        $res = $this->goods_cate->storeParent($attr);
        if ($res) {
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(406, '失败');
        }
    }

    /**
     * @GET
     * 产品大类的编辑
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editParent(Request $request)
    {
        //产品大类的id
        $id = $request->input('id');
        if (empty($id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $goods_name = $this->goods_cate->editParent($id);
        if ($goods_name) {
            return $this->successResponse(200, '成功', $goods_name);
        } else {
            return $this->errorResponse(406, '失败');
        }
    }

    /**
     * @POST
     * 产品大类编辑数据提交
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateParent(Request $request)
    {
        $id = $request->input('id');
        $goods_name = $this->dealRequest($request->only('goods_name'));
        if (empty($goods_name) || empty($id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $res = $this->goods_cate->updateParent($id, $goods_name);
        if ($res) {
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(406, '失败');
        }
    }

    /**
     * @DELETE
     * 产品大类删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyParent(Request $request)
    {
        $id = $request->input('id');
        if (empty($id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $res = $this->goods_cate->destroyParent($id);
        if ($res) {
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(406, '失败');
        }
    }

    /**
     * @POST
     * 添加 产品子类
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeChild(Request $request)
    {
        $pid = $request->input('pid');
        $arr = $this->dealRequest($request->input('goods_cate'));
        //校验数据 1.不为空 2.价格是正确的价格
        if (empty($arr) || empty($pid)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        foreach ($arr as $item) {
            if(empty($item['goods_name'])||empty($item['price'])||empty($item['sever_time'])){
                return $this->errorResponse(405, '子产品参数不完整');
            }
            if(!is_numeric($item['price'])||$item['price']<0){
                return $this->errorResponse(405, '子产品参数有错误');
            }
        }
        $merchant_id = $this->getMesByToken()['merchant_id'];

        //获取大类产品的最大排序
        $child_sort = DB::table('wr_goods_cate')
            ->where('merchant_id', $merchant_id)
            ->where('pid', $pid)
            ->where('level', 1)
            ->orderBy('sort', 'desc')
            ->value('sort');
        $attr = array();
        foreach ($arr as $k => $value) {
            $attr[$k]['goods_name'] = $value['goods_name'];
            $attr[$k]['sort'] = empty($child_sort) ? $k : $child_sort + $k + 1;
            $attr[$k]['pid'] = $pid;
            $attr[$k]['merchant_id'] = $merchant_id;
            $attr[$k]['price'] = $value['price'];
            $attr[$k]['sever_time'] = $value['sever_time'];
            $attr[$k]['level'] = 1;
            $attr[$k]['created_at'] = time();
            $attr[$k]['updated_at'] = time();
        }
        $res = $this->goods_cate->storeChild($attr);
        if ($res) {
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(406, '失败');
        }
    }

    /**
     * @GET
     * 产品子类的编辑
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editChild(Request $request)
    {
        //产品子类的id
        $id = $request->input('id');
        if (empty($id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $goods_name = $this->goods_cate->editChild($id);
        if ($goods_name) {
            return $this->successResponse(200, '成功', $goods_name);
        } else {
            return $this->errorResponse(406, '失败');
        }
    }

    /**
     * @POST
     * 产品子类的数据提交
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateChild(Request $request)
    {
        $id = $request->input('id');
        $goods_name = $request->input('goods_name');
        $price = $request->input('price');
        $sever_time = $request->input('sever_time');
        $attr = array(
            'goods_name' => $goods_name,
            'price' => $price,
            'sever_time' => $sever_time,
            'id' => $id
        );
        $attr = $this->dealRequest($attr);
        if (empty($attr['goods_name']) || empty($attr['price']) || empty($attr['sever_time']) || empty($attr['id'])) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $res = $this->goods_cate->updateChild($id, $attr);
        if ($res) {
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(406, '失败');
        }
    }

    /**
     * @产品子类的删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyChild(Request $request)
    {
        $id = $request->input('id');
        if (empty($id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $res = $this->goods_cate->destroyChild($id);
        if ($res) {
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(406, '失败');
        }
    }

}