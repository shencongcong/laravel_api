<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:21
 */

namespace App\Api\Controllers\Member;

use App\Api\Controllers\ApiBaseController;
use App\Api\Transformer\WaiterTransformer;
use App\Repositories\Contracts\WaiterLevelRepository;
use Illuminate\Http\Request;
use App\Repositories\Contracts\WaiterRepository;
use Illuminate\Support\Facades\DB;


/**
 * Class WaiterController
 * @package App\Api\Controllers\Member
 */
class WaiterController extends ApiBaseController
{
    private $waiter;
    protected $waiterTransformer;

    public function __construct(WaiterRepository $waiterRepository, WaiterTransformer $transformer)
    {
        $this->waiter = $waiterRepository;
        $this->waiterTransformer = $transformer;
    }

    /**
     * 获取所有的职位
     * @GET
     * @param WaiterLevelRepository $levelRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function allLevel(WaiterLevelRepository $levelRepository)
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $level_arr = $levelRepository->index($merchant_id);
        if ($level_arr) {
            return $this->successResponse(200, '成功', $level_arr);
        } else {
            return $this->errorResponse(204, '暂无内容');
        }
    }

    /**
     * 根据职位获取服务师列表
     * @POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function waiterListByLevel(Request $request)
    {
        $shop_id = $this->getMesByToken()['shop_id'];
        $level_id = $this->dealStr($request->input('level_id'));
        $merchant_id = $this->getMesByToken()['merchant_id'];
        if (empty($level_id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $waiter_arr = $this->waiter->waiterListByLevel($level_id, $shop_id, $merchant_id);
        $attr = array();
        if ($waiter_arr) {
            foreach ($waiter_arr as $k => $v) {
                $attr[$k]['level_name'] = DB::table('wr_waiter_level')
                    ->where('id', $v['level'])
                    ->value('name');
                //作品数量
                $attr[$k]['album_num'] = DB::table('wr_waiter_album')
                    ->where('waiter_id', $v['id'])
                    ->count();
                //预约次数
                $attr[$k]['appoint_num'] = DB::table('wr_appoint')
                    ->where('waiter_id', $v['id'])
                    ->count();
                $attr[$k]['id'] = $v['id'];
                $attr[$k]['nickname'] = $v['nickname'];
                $attr[$k]['img'] = $v['img'];
            }

            return $this->successResponse(200, '成功', $attr);
        } else {
            return $this->errorResponse(204, '暂无内容');
        }
    }

    /**
     * 服务师全部列表
     * @GET
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function waiterList(Request $request)
    {
        $shop_id = $this->getMesByToken()['shop_id'];
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $waiter_arr = $this->waiter->waiterList($shop_id, $merchant_id);
        $attr = array();
        if ($waiter_arr) {
            foreach ($waiter_arr as $k => $v) {
                $attr[$k]['level_name'] = DB::table('wr_waiter_level')
                    ->where('id', $v['level'])
                    ->value('name');
                //作品数量
                $attr[$k]['album_num'] = DB::table('wr_waiter_album')
                    ->where('waiter_id', $v['id'])
                    ->count();
                //预约次数
                $attr[$k]['appoint_num'] = DB::table('wr_appoint')
                    ->where('waiter_id', $v['id'])
                    ->count();
                $attr[$k]['id'] = $v['id'];
                $attr[$k]['nickname'] = $v['nickname'];
                $attr[$k]['img'] = $v['img'];
            }
            return $this->successResponse(200, '成功', $attr);
        } else {
            return $this->errorResponse(204, '暂无内容');
        }
    }

    /**
     * 服务师详情
     * @GET
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function waiterShow(Request $request)
    {
        $waiter_id = $request->input('waiter_id');
        if (empty($waiter_id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $waiter_arr = $this->waiter->waiterShow($waiter_id);

        if ($waiter_arr) {
            $waiter_arr['level_name'] = DB::table('wr_waiter_level')
                ->where('id', $waiter_arr['level'])
                ->value('name');
            $waiter_arr['album_num'] = DB::table('wr_waiter_album')
                ->where('waiter_id', $waiter_arr['id'])
                ->count();
            $waiter_arr['appoint_num'] = DB::table('wr_appoint')
                ->where('waiter_id', $waiter_arr['id'])
                ->count();
            $waiter_grade = DB::table('wr_waiter_comment')
                ->where('waiter_id', $waiter_id)
                ->where('deleted_at', null)
                ->avg('waiter_grade');
            $waiter_arr['waiter_grade'] = round($waiter_grade, 1);
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
                $waiter_arr['comment'] = array(
                    array('max'=>$stance_max),array('max'=>$art_max),array('max'=>$punctual_max)
                );
            }else{
                $waiter_arr['comment'] = array(
                    array('max'=>''),array('max'=>''),array('max'=>'')
                );
            }
            return $this->successResponse(200, '成功', $this->waiterTransformer->waiterShowTransformer($waiter_arr));
        } else {
            return $this->errorResponse(406, '失败');
        }
    }

    /**
     * @GET
     * 根据产品筛选服务师
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function waiterListByGoods(Request $request)
    {
        $shop_id = $this->getMesByToken()['shop_id'];
        $goods_id = $request->input('goods_id');
        //根据产品获取服务师id
        $waiter_id_goods = DB::table('wr_waiter_goods')
            ->where('goods_id', $goods_id)
            ->pluck('waiter_id');
        //根据店铺id获取服务师id
        $waiter_id_shop = DB::table('wr_shop_waiter')
            ->where('shop_id', $shop_id)
            ->pluck('waiter_id');
        if ($waiter_id_goods && $waiter_id_shop) {
            $waiter_id = array_intersect($waiter_id_goods, $waiter_id_shop);
            $waiter_arr = $this->waiter->waiterListByGoodsId($waiter_id);
            return $this->successResponse(200, '成功', $waiter_arr);
        } else {
            return $this->errorResponse(204, '暂无内容');
        }
    }
}

