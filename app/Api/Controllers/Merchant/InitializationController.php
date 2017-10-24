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
use Illuminate\Support\Facades\DB;

/**
 * Class WaiterController
 * @package App\Api\Controllers
 */
class InitializationController extends ApiBaseController
{
    public function int()
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $shop_num = DB::table('wr_shop')
            ->where('merchant_id',$merchant_id)
            ->where('deleted_at',null)
            ->count();
        if($shop_num==0){
            //未创建门店 
            return $this->errorResponse(4010, '未创建门店');
        }else{
            //门店创建  检查产品是否创建
            $goods_parent_pid = DB::table('wr_goods_cate')
                ->where('merchant_id',$merchant_id)
                ->where('level',0)
                ->pluck('id');
            if(count($goods_parent_pid)==0){
                return $this->errorResponse(4011, '产品大类未创建');
            }else{
                //产品大类创建，检查子类是否创建
                $goods_child_id = DB::table('wr_goods_cate')
                    ->where('merchant_id',$merchant_id)
                    ->whereIn('pid',$goods_parent_pid)
                    ->where('level',1)
                    ->pluck('id');
                if(count($goods_child_id)==0){
                    //跳转到创建子类的api
                    return $this->successResponse(4012, '产品子类未创建',$goods_parent_pid[0]);
                }else{
                    //检查职位是否创建
                    $level_num = DB::table('wr_waiter_level')
                        ->where('merchant_id',$merchant_id)
                        ->count();
                    if($level_num==0){
                        //未创建门店
                        return $this->errorResponse(4013, '服务师职位未创建');
                    }else{
                        return $this->successResponse(200, '初始化完成');
                    }
                    
                }
            }
        }
    }

    /*public function goods()
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $goods_parent_pid = DB::table('wr_goods_cate')
            ->where('merchant_id',$merchant_id)
            ->where('level',0)
            ->pluck('id');
        if(count($goods_parent_pid)==0){
            return $this->errorResponse(4011, '产品大类未创建');
        }elseif(count($goods_parent_pid)==1){
            $goods_child_id = DB::table('wr_goods_cate')
                ->where('merchant_id',$merchant_id)
                ->whereIn('pid',$goods_parent_pid)
                ->where('level',1)
                ->pluck('id');
            if(count($goods_child_id)==0){
                //跳转到创建子类的api
                return $this->successResponse(4012, '产品子类未创建',$goods_parent_pid);
            }else{
                return $this->successResponse(200, '产品子类已经创建');
            }
        }else{
            $goods_child_id = DB::table('wr_goods_cate')
                ->where('merchant_id',$merchant_id)
                ->whereIn('pid',$goods_parent_pid)
                ->where('level',1)
                ->pluck('id');
            if(count($goods_child_id)==0){
                //跳转到创建子类的api
                $attr[0] = $goods_parent_pid[0];
                return $this->successResponse(4012, '产品子类未创建',$attr);
            }else{
                return $this->successResponse(200, '产品子类已经创建');
            }
        }
    }*/

   /* public function level()
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $level_num = DB::table('wr_waiter_level')
            ->where('merchant_id',$merchant_id)
            ->count();
        if($level_num==0){
            //未创建门店
            return $this->errorResponse(4013, '服务师职位未创建');
        }else{
            return $this->successResponse(200, '服务师职位已创建');
        }
    }*/
}