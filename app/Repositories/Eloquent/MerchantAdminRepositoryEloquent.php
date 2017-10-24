<?php

namespace App\Repositories\Eloquent;

use App\Models\MerchantAdmin;
use Illuminate\Support\Facades\Hash;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\MerchantAdminRepository as MerchantAdminRepository;
use DB;

/**
 * Class MerchantAdminRepositoryEloquent
 * @package App\Repositories\Eloquent
 */
class MerchantAdminRepositoryEloquent extends BaseRepository implements MerchantAdminRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MerchantAdmin::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        $list = $this->paginate();
        $items = $list->toArray();
        foreach ($items['data'] as $key => $value) {
            $items['data'][$key]['button'] = $this->model->getActionButtons('merchantAdmin', $value['id']);
        }
        $data['data'] = $items['data'];
        $data['page'] = $list;
        return $data;
    }

    /**
     * @param array $attr
     * @return mixed
     */
    public function createMerchantAdmin(array $attr)
    {
        $admin = DB::table('wr_merchant_admin')->where(['admin_tel' => $attr['admin_tel']])->get();
        if ($admin) {
            flash('商户手机号不能重复', 'error');
            return;
        }
        $attr['admin_password'] = bcrypt($attr['admin_password']);
        $res = $this->create($attr);
        if ($res) {
            flash('商户管理员新增成功', 'success');
        } else {
            flash('商户管理新增失败', 'error');
        }
        return $res;
    }

    /**
     * @param $admin_tel
     * @param $admin_password
     * @return bool
     */
    public function checkLogin($admin_tel, $admin_password)
    {
        $merchant = $this->model
            ->where('admin_tel', '=', $admin_tel)
            ->first();
        if (count($merchant) !== 0) {
            $merchant_arr = $merchant->toArray();
            if (Hash::check($admin_password, $merchant_arr['admin_password'])) {
                return array('id' => $merchant_arr['id'], 'merchant_id' => $merchant_arr['merchant_id']);
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * 获取商户信息
     * @param $id
     * @return array|bool
     */
    public function index($id)
    {
        $admin_obj = $this->model->where('id', $id)->first();
        if (count($admin_obj) !== 0) {
            $admin = $admin_obj->toArray();
            return $admin;
        } else {
            return false;
        }
    }

    /**
     * 修改商户管理员的信息
     * @param $arr
     * @param $id
     * @return bool
     */
    public function merchantAdminUpdate($arr, $id)
    {
        $res = $this->model->where('id', $id)->update($arr);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 管理员登录账号展示
     * @param $id
     * @return bool
     */
    public function showTel($id)
    {
        $res = $this->model->where('id', $id)->value('admin_tel');
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    /**
     * 商户管理员密码修改
     * @param $merchant_tel
     * @param $id
     */
    public function updatePsw($array, $id)
    {
        $res = $this->model
            ->where('id', $id)
            ->update($array);
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    /**
     * 忘记密码验证通过后  修改密码
     * @param $id
     * @param $attr
     * @return mixed
     */
    public function forgetPwdUpdatePwd($id, $attr)
    {
        return $res = $this->model
            ->where('id', $id)
            ->update($attr);
    }

}
