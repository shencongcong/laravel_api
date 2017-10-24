<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

use App\Repositories\Contracts\WaiterLevelRepository as WaiterLevelRepositoryInterface;
use App\Models\WaiterLevel;
use Cache;

/**
 * Class MenuRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class WaiterLevelRepositoryEloquent extends BaseRepository implements WaiterLevelRepositoryInterface
{
    /**
     * Specify Model class name
     * @return string
     */
    public function model()
    {
        return WaiterLevel::class;
    }

    /**
     * 显示商户下的所有职位
     * @param $merchant_id
     * @return array|bool
     */
    public function index($merchant_id)
    {
        $res_obj = $this->model
            ->where('merchant_id', $merchant_id)
            ->select('name', 'id')
            ->get();
        if (count($res_obj) !== 0) {
            $res = $res_obj->toArray();
            return $res;
        } else {
            return false;
        }
    }

    /**
     * 添加职位
     * @param $arr
     * @return bool
     */
    public function store($arr)
    {
        $res = $this->model->insert($arr);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 职位编辑
     * @param $id
     * @return bool|mixed
     */
    public function edit($id)
    {
        $res = $this->model->find($id);
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    /**
     * 职位更新
     * @param $id
     * @param $arr
     * @return bool|int
     */
    public function levelUpdate($id, $arr)
    {
        return $this->model->where('id', $id)->update($arr);

    }

    /**
     * 职位删除
     * @param $level_id
     * @return bool|null
     */
    public function destroy($level_id)
    {
        return $this->model->where('id', $level_id)->delete();
    }

}
