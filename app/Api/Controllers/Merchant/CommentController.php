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
use App\Repositories\Contracts\WaiterCommentRepository;
use Illuminate\Support\Facades\DB;


/**
 * Class CommentController
 * @package App\Api\Controllers\Merchant
 */
class CommentController extends ApiBaseController
{
    private $comment;

    public function __construct(WaiterCommentRepository $commentRepository)
    {
        $this->comment = $commentRepository;
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

