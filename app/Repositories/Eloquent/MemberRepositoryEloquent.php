<?php

namespace App\Repositories\Eloquent;

use App\models\Member;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\MemberRepository as MemberRepositoryInterface;
use Cache;
use DB;

/**
 * Class MenuRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class MemberRepositoryEloquent extends BaseRepository implements MemberRepositoryInterface
{
    /**
     * Specify Model class name
     * @return string
     */
    public function model()
    {
        return Member::class;
    }

    /**
     * 获取客户信息
     * @param $member_id
     * @return bool
     */
    public function index($member_id)
    {
        $member_obj = $this->model
            ->where('id', $member_id)
            ->where('status', 1)
            ->first();
        if (count($member_obj) !== 0) {
            $arr = $member_obj->toArray();
            return $arr;
        } else {
            return false;
        }

    }

    /**
     * 客户信息更新提交
     * @param $member_id
     * @param $arr
     * @return mixed
     */
    public function memberUpdate($member_id, $arr)
    {
        $res = $this->model
            ->where('id', $member_id)
            ->update($arr);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 根据电话获取客户信息
     * @param $tel
     * @return bool
     */
    public function indexByTel($tel)
    {
        $res = DB::table('wr_member')
            ->leftjoin('wr_merchant', 'wr_member.merchant_id', '=', 'wr_merchant.id')
            ->where(['wr_member.tel' => $tel, 'wr_member.status' => 1, 'wr_member.deleted_at' => null])
            ->select('wr_member.id', 'wr_member.merchant_id')
            ->get();
        $res = array_map('get_object_vars', $res);
        return $res;
    }

    /**
     * 根据商户号，电话，获取客户的id
     * @param $merchant_id
     * @param $tel
     * @return bool
     */
    public function getMemberId($merchant_id, $tel)
    {
        $res = $this->model
            ->where('merchant_id', $merchant_id)
            ->where('tel', $tel)
            ->where('status', 1)
            ->value('id');
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }


    /**
     * 根据open_id获取会员信息
     * @param $open_id
     * @return bool
     */
    public function memberByOpenId($open_id)
    {
        $res_obj = $this->model
            ->join('wr_merchant','wr_merchant.id','=','wr_member.merchant_id')
            ->where('wr_member.open_id', $open_id)
            ->where('wr_member.status', 1)
            ->select('wr_member.merchant_id','wr_member.id')
            ->get();
        if (count($res_obj) !== 0) {
            $res = $res_obj->toArray();
            return $res;
        } else {
            return false;
        }
    }

    /**
     * 根据open_id ,merchant_id 获取会员的id
     * @param $merchant_id
     * @param $open_id
     */
    public function getMemberIdByOpenId($merchant_id, $open_id)
    {
        $res = $this->model
            ->where('merchant_id', $merchant_id)
            ->where('open_id', $open_id)
            ->where('status', 1)
            ->value('id');
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    /**
     * 根据会员id检查手机号码是否存在
     * @param $member_id
     * @return bool
     */
    public function checkTelByMemberId($member_id)
    {
        $tel = $this->model
            ->where('id', $member_id)
            ->where('status', 1)
            ->value('tel');
        if ($tel) {
            return $tel;
        } else {
            return false;
        }
    }

    /**
     * 手机号码不存在时，绑定手机号码
     * @param $member_id
     * @param $arr
     * @return mixed
     */
    public function bindTel($member_id, $arr)
    {
        try {
            $res = $this->model
                ->where('id', $member_id)
                ->where('status', 1)
                ->update($arr);
            if ($res == 1 || $res == 0) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    //商户端
    /**
     * 展示所有的会员列表
     * @param $merchant_id
     * @return int
     */
    public function memberList($merchant_id)
    {
        try {
            $member_obj = $this->model
                ->where('merchant_id', $merchant_id)
                ->get();
            if (count($member_obj) !== 0) {
                $member_arr = $member_obj->toArray();
                return $member_arr;
            } else {
                return 204;
            }
        } catch (\Exception $e) {
            return 406;
        }
    }
}
