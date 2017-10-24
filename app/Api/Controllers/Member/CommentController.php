<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:21
 */

namespace App\Api\Controllers\Member;

use App\Api\Controllers\ApiBaseController;
use Illuminate\Http\Request;
use App\Repositories\Contracts\WaiterCommentRepository;
use Illuminate\Support\Facades\DB;


/**
 * Class CommentController
 * @package App\Api\Controllers\Member
 */
class CommentController extends ApiBaseController
{
    private $comment;

    public function __construct(WaiterCommentRepository $commentRepository)
    {
        $this->comment = $commentRepository;
    }

    /**
     * 评论添加
     * @POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $member_id = $this->getMesByToken()['id'];
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $arr = $this->dealRequest($request->all());
        $appoint_id = $arr['appoint_id'];
        $appoint_arr = DB::table('wr_appoint')
            ->where('id', $appoint_id)
            ->select('shop_id', 'waiter_id')
            ->first();
        $attr['member_id'] = $member_id;
        $attr['merchant_id'] = $merchant_id;
        $attr['appoint_id'] = $appoint_id;
        $attr['waiter_id'] = $appoint_arr->waiter_id;
        $attr['waiter_grade'] = $arr['waiter_grade'];
        $attr['punctual_id'] = $arr['punctual_id'];
        $attr['stance_id'] = $arr['stance_id'];
        $attr['art_id'] = $arr['art_id'];
        $attr['shop_id'] = $appoint_arr->shop_id;
        $res = $this->comment->store($attr);
        if ($res !== 406 && $res == true) {
            return $this->successResponse(200, '成功');
        } elseif ($res == 406) {
            return $this->errorResponse(406, '数据库异常');
        } else {
            return $this->errorResponse(400, '数据异常，添加失败');
        }
    }

    /**
     * 所有的评论标签
     * GET
     * @return \Illuminate\Http\JsonResponse
     */
    public function allCommentTag(Request $request)
    {
        $pid = DB::table('wr_comment_tag')
            ->where('level', 0)
            ->pluck('id');
        foreach ($pid as $k => $v) {
            $child_obj[$k] = DB::table('wr_comment_tag')
                ->where('pid', $v)
                ->where('level', 1)
                ->select('id', 'introduce')
                ->orderBy('sort')
                ->get();
        }
        return $this->successResponse(200, '成功', $child_obj);
    }


    /**
     * 服务师的评价展示
     * @POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function waiterComment(Request $request)
    {
        $waiter_id = $this->dealStr($request->input('waiter_id'));
        if(empty($waiter_id)){
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $comment = DB::table('wr_waiter_comment')
            ->where('waiter_id', $waiter_id)
            ->where('deleted_at', null)
            ->select('punctual_id', 'art_id', 'stance_id')
            ->get();
        if($comment){
            foreach ($comment as $k => $v) {
                $punctual_arr[$k] = $v->punctual_id;
                $art_arr[$k] = $v->art_id;
                $stance_arr[$k] = $v->stance_id;
            }
            //判断值相同的次数
            $punctual_num =array_count_values($punctual_arr);
            $art_num = array_count_values($art_arr);
            $stance_num = array_count_values($stance_arr);
            $tag_arr = $punctual_num+$art_num+$stance_num;
        }else{
            $tag_arr = array();
        }
        $pid = DB::table('wr_comment_tag')
            ->where('level', 0)
            ->pluck('id');
        foreach ($pid as $k => $v) {
            $attr[$k] = DB::table('wr_comment_tag')
                ->where('pid', $v)
                ->where('level', 1)
                ->select('id', 'introduce')
                ->orderBy('sort')
                ->get();
        }
        foreach ($attr as $k1 =>&$v1){
            foreach ($v1 as $k2=>&$v2){
                $res = array_key_exists($v2->id,$tag_arr);
                if($res ==true){
                    $v2->comment_num = $tag_arr[$v2->id];
                }else{
                    $v2->comment_num = 0;
                }
            }
        }

        return $this->successResponse(200, '成功', $attr);
    }
}

