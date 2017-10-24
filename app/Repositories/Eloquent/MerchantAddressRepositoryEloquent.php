<?php

namespace App\Repositories\Eloquent;

use App\Models\MerchantAddress;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\MerchantAddressRepository as MerchantAddressRepositoryInterface;
use DB;

/**
 * Class MerchantAddressRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class MerchantAddressRepositoryEloquent extends BaseRepository implements MerchantAddressRepositoryInterface
{
    /**
     * Specify Model class name
     * @return string
     */
    public function model()
    {
        return MerchantAddress::class;
    }

    /**
     * 商户申请客户二维码地址信息展示
     * @param $merchant_id
     * @return int
     */
    public function index($merchant_id)
    {
        try{
            $res = DB::table('wr_merchant_address')
                ->where('merchant_id',$merchant_id)
                ->where('deleted_at',null)
                ->first();
            if($res){
                $arr = (array)$res;
                if($arr['is_send']==1){
                    //未寄送
                    return $arr;
                }elseif($arr['is_send']==2){
                    //寄送中
                    return 4015;
                }
            }else{
                //暂无申请地址
                return 204;
            }
        }catch (\Exception $e){
            //数据库异常
            return 406;
        }
        
        
    }

    /**
     * 商户申请客户二维码地址信息提交
     * @param $arr
     * @return bool|int
     */
    public function store($arr)
    {
        try{
            $res = $this->model->create($arr);
            if($res){
                return true;
            }else{
                return false;
            }
        }catch (\Exception $e){
            return 406;
        }
    }

    /**
     * 商户申请客户二维码地址信息提交再次提交
     * @param $id
     * @param $arr
     * @return bool|int
     */
    public function againStore($id, $arr)
    {
        try{
            $res = $this->model
                ->where('id',$id)
                ->update($arr);
            if($res){
                return true;
            }else{
                return false;
            }
        }catch (\Exception $e){
            return 406;
        }
    }

    public function getAll()
    {
        $list = $this->paginate();
        $items = $list->toArray();
        foreach ($items['data'] as $key => $value) {
            $items['data'][$key]['button'] = $this->model->getActionButtons('merchantCode',$value['id']);
        }
        $data['data'] = $items['data'];
        $data['page'] = $list;
        return $data;
    }

    public function updateMerchantCode(array $attr,$id)
    {
        $res = $this->update($attr,$id);
        if ($res){
            flash('更新成功','success');
        }else{
            flash('更新失败','error');
        }
    }
}
