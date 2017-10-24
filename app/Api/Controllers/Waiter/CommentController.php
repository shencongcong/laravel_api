<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:21
 */

namespace App\Api\Controllers\Waiter;

use App\Api\Controllers\ApiBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\WaiterCommentRepository;

/**
 * 服务师评价
 * Class CommentController
 * @package App\Api\Controllers\Waiter
 */
class CommentController extends ApiBaseController
{
    private $comment;

    public function __construct(WaiterCommentRepository $commentRepository)
    {
        $this->comment = $commentRepository;
    }

    /**
     * 服务师评价首页
     * @POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $shop_id = $this->dealStr($request->input('shop_id'));
        $waiter_id = $this->getMesByToken()['id'];
        if(empty($shop_id)){
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        if ($shop_id == -1) {
            $comment = $this->comment->waiterCommentList($waiter_id);
        } else {
            $comment = $this->comment->waiterCommentListByShop($waiter_id,$shop_id);
        }

        if ($comment !== 204 && $comment !== 406) {
            $attr = array();
            foreach ($comment as $k => $v) {
                $member_obj = DB::table('wr_member')
                    ->where('id', $v['member_id'])
                    ->select('member_name', 'img')
                    ->first();
                $attr[$k]['member_img'] = $member_obj->img;
                $attr[$k]['member_name'] = $member_obj->member_name;
                $attr[$k]['created_at'] = date('Y-m-d', $v['created_at']);
                $attr[$k]['waiter_grade'] = $v['waiter_grade'];
                $attr[$k]['shop_name'] = DB::table('wr_shop')
                    ->where('id', $v['shop_id'])
                    ->value('shop_name');
                $goods_name = DB::table('wr_appoint')
                    ->join('wr_goods_cate', 'wr_goods_cate.id', '=', 'wr_appoint.goods_id')
                    ->where('wr_appoint.id', $v['appoint_id'])
                    ->value('goods_name');
                if ($goods_name) {
                    $attr[$k]['goods_name'] = $goods_name;
                } else {
                    $attr[$k]['goods_name'] = null;
                }
                //服务标签
                $attr[$k]['stance_name'] = DB::table('wr_comment_tag')
                    ->where('id', $v['stance_id'])
                    ->value('introduce');
                //技能标签
                $attr[$k]['art_name'] = DB::table('wr_comment_tag')
                    ->where('id', $v['art_id'])
                    ->value('introduce');
                //技能标签
                $attr[$k]['punctual_name'] = DB::table('wr_comment_tag')
                    ->where('id', $v['punctual_id'])
                    ->value('introduce');
            }
            return $this->successResponse(200, '成功', $attr);
        } elseif ($comment == 204) {
            return $this->errorResponse(204, '暂无评价');
        } elseif ($comment == 406) {
            return $this->errorResponse(406, '数据库异常');
        }
    }

}

