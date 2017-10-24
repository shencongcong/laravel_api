<?php

namespace App\Repositories\Eloquent;

use App\Models\WaiterComment;
use DB;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\Contracts\WaiterCommentRepository as WaiterCommentRepository;

class WaiterCommentRepositoryEloquent extends BaseRepository implements WaiterCommentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WaiterComment::class;
    }

    /**
     * 评论新增
     * @param $arr
     * @return bool|int
     */
    public function store($arr)
    {
        DB::beginTransaction();
        try {
            $user1 = $this->model->create($arr);
            $user2 = DB::table('wr_appoint')
                ->where('id', $arr['appoint_id'])
                ->update(array('is_comment' => 1));
            if ($user1 && $user2) {
                DB::commit();
               return true;
            }else{
                DB::rollBack();
                return false;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return 406;
        }
    }


    /**
     * 服务师评价列表
     * @param $waiter_id
     * @return int
     */
    public function waiterCommentList($waiter_id)
    {
        try{
            $comment_obj = $this->model
                ->where('waiter_id',$waiter_id)
                ->get();
            if(count($comment_obj)!==0){
                $comment_arr = $comment_obj->toArray();
                return $comment_arr;
            }else{
                return 204;
            }
        }catch (\Exception $e){
            return 406;
        }
    }

    /**
     * 根据门店id,服务师id 获取评价列表
     * @param $waiter_id
     * @param $shop_id
     * @return int
     */
    public function waiterCommentListByShop($waiter_id, $shop_id)
    {
        try{
            $comment_obj = $this->model
                ->where('waiter_id',$waiter_id)
                ->where('shop_id',$shop_id)
                ->get();
            if(count($comment_obj)!==0){
                $comment_arr = $comment_obj->toArray();
                return $comment_arr;
            }else{
                return 204;
            }
        }catch (\Exception $e){
            return 406;
        }
    }

}
