<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:21
 */

namespace App\Api\Controllers\Merchant;

use App\Api\Controllers\ApiBaseController;
use App\Api\Transformer\WaiterLevelTransformer;
use Illuminate\Http\Request;
use App\Repositories\Contracts\WaiterLevelRepository;


/**
 * Class WaiterLevelController
 * @package App\Api\Controllers
 */
class WaiterLevelController extends ApiBaseController
{
    private $waiterLevel;
    protected $waiterLevelTransformer;

    public function __construct(WaiterLevelRepository $waiterLevelRepository, WaiterLevelTransformer $waiterLevelTransformer)
    {
        $this->waiterLevel = $waiterLevelRepository;
        $this->waiterLevelTransformer = $waiterLevelTransformer;
    }


    /**
     * @GET
     * 显示商户下的所有职位
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $level = $this->waiterLevel->index($merchant_id);
        if ($level) {
            return $this->successResponse(200, '成功', $this->waiterLevelTransformer->transformer($level));
        } else {
            return $this->errorResponse(204, '暂无职位');
        }
    }

    /**
     * @POST
     * 商户添加职位
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $name = $this->dealRequest($request->input('name'));
        $merchant_id = $this->getMesByToken()['merchant_id'];
        if (empty($name)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $attr = array();
        foreach ($name as $k => $value) {
            $attr[$k]['name'] = $value;
            $attr[$k]['merchant_id'] = $merchant_id;
            $attr[$k]['created_at'] = time();
            $attr[$k]['updated_at'] = time();
        }
        $res = $this->waiterLevel->store($attr);
        if ($res) {
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(406, '失败');
        }
    }

    /**
     * @POST
     * 职位 修改
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $attr = $this->dealRequest($request->only('name', 'id'));
        if (empty($attr['name']) || empty($attr['id'])) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $arr['name'] = $attr['name'];
        $res = $this->waiterLevel->levelUpdate($attr['id'], $arr);
        if ($res) {
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(406, '失败');
        }
    }

    /**
     * @GET
     * 职位编辑
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request)
    {
        $waiter_level_id = $request->input('id');
        if (empty($waiter_level_id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $arr = $this->waiterLevel->edit($waiter_level_id);
        if ($arr) {
            return $this->successResponse(200, '成功', $this->waiterLevelTransformer->oneTransformer($arr));
        } else {
            return $this->errorResponse(406, '失败');
        }

    }

    /**
     * @DELETE
     * 职位删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $level_id = $request->input('id');
        if (empty($level_id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $res = $this->waiterLevel->destroy($level_id);
        if ($res) {
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(406, '失败');
        }
    }

}