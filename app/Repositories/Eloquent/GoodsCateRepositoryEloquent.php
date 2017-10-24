<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

use App\Repositories\Contracts\GoodsCateRepository as GoodsCateRepositoryInterface;
use App\Models\GoodsCate;

/**
 * Class MenuRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class GoodsCateRepositoryEloquent extends BaseRepository implements GoodsCateRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GoodsCate::class;
    }

    /*
     * 商户端
     * */

    /**
     * 所有产品展示
     * @param $merchant_id
     * @return bool
     */
    public function index($merchant_id)
    {
        $parent_Obj = $this->model
            ->where('merchant_id', $merchant_id)
            ->where('level', 0)
            ->orderBy('sort', 'asc')
            ->select('id', 'goods_name')
            ->get();
        if (count($parent_Obj) !== 0) {
            $parent = $parent_Obj->toArray();
            foreach ($parent as $k => &$v) {
                $v['child'] = $this->model
                    ->where('merchant_id', $merchant_id)
                    ->where('level', 1)
                    ->where('pid', $v['id'])
                    ->orderBy('sort', 'asc')
                    ->select('id', 'goods_name', 'price')
                    ->get()->toArray();
                if (empty($v['child'])) {
                    unset($v['child']);
                }
            }
            return $parent;
        } else {
            return false;
        }
    }

    /**
     * 产品大类的添加
     * @param $arr
     * @return bool
     */
    public function storeParent($arr)
    {
        $res = $this->model->insert($arr);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 产品大类的添加
     * @param $arr
     * @return bool
     */
    public function storeChild($arr)
    {
        $res = $this->model->insert($arr);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 产品大类的编辑
     * @param $id
     * @return bool
     */
    public function editParent($id)
    {
        $res = $this->model
            ->where('id', $id)
            ->value('goods_name');
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    /**
     * 产品大类编辑数据提交
     * @param $id
     * @param $arr
     * @return bool
     */
    public function updateParent($id, $arr)
    {
        $res = $this->model
            ->where('id', $id)
            ->update($arr);
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    /**
     * 产品大类的删除
     * @param $id
     * @return bool
     */
    public function destroyParent($id)
    {
        DB::beginTransaction();
        //差看是否有子类产品
        $get_children_cate = $this->model->where('pid', $id)->first();
        if (!empty($get_children_cate)) {
            try {
                $res1 = DB::table('wr_goods_cate')->where('id', $id)->delete();
                $res2 = DB::table('wr_goods_cate')->where('pid', $id)->delete();
                if ($res1 && $res2) {
                    DB::commit();
                    return true;
                } else {
                    DB::rollBack();
                    return false;
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return false;
            }
        } else {
            $res1 = $this->model->where('id', $id)->delete();
            if ($res1) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * 产品子类的数据编辑
     * @param $id
     * @return bool
     */
    public function editChild($id)
    {
        $arr_obj = $this->model
            ->where('id', $id)
            ->select('goods_name', 'price', 'sever_time', 'pid')
            ->first();
        if (count($arr_obj) !== 0) {
            $arr = $arr_obj->toArray();
            $parent_goods_name = $this->model
                ->where('id', $arr['pid'])
                ->value('goods_name');
            $arr['parent_goods_name'] = $parent_goods_name;
            unset($arr['pid']);
            return $arr;
        } else {
            return false;
        }
    }

    /**
     * 产品子类的数据编辑提交
     * @param $id
     * @param $arr
     * @return bool
     */
    public function updateChild($id, $arr)
    {
        $res = $this->model
            ->where('id', $id)
            ->update($arr);
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }

    /**
     * 产品子类的删除
     * @param $id
     * @return bool
     */
    public function destroyChild($id)
    {
        $res1 = $this->model->where('id', $id)->delete();
        if ($res1) {
            return true;
        } else {
            return false;
        }
    }


    /*
     * 客户端
     * */

    /**
     * 获取所有的服务产品大类
     * @param $merchant_id
     * @return bool
     */
    public function allParent($merchant_id)
    {
        $parent_obj = $this->model
            ->where('merchant_id', $merchant_id)
            ->where('level', 0)
            ->select('id', 'goods_name')
            ->get();
        if (count($parent_obj) !== 0) {
            $arr = $parent_obj->toArray();
            return $arr;
        } else {
            return false;
        }
    }

    /**
     * 获取所有的产品子类（根据大类排列）
     * @param $merchant_id
     * @return array|bool
     */
    public function allChild($merchant_id)
    {
        $parent_obj = $this->model
            ->where('merchant_id', $merchant_id)
            ->where('level', 0)
            ->select('id', 'goods_name')
            ->get();

        if (count($parent_obj) !== 0) {
            $arr = $parent_obj->toArray();
            $attr = array();
            foreach ($arr as $k => $v) {
                $child_obj = $this->model
                    ->where('merchant_id', $merchant_id)
                    ->where('level', 1)
                    ->where('pid', $v['id'])
                    ->orderBy('sort', 'asc')
                    ->select('id', 'goods_name', 'sever_time', 'price')
                    ->get();
                if (count($child_obj) !== 0) {
                    $child_arr = $child_obj->toArray();
                    foreach ($child_arr as $k1 => $v1) {
                        $attr[$k . $k1]['id'] = $v1['id'];
                        $attr[$k . $k1]['goods_name'] = $v1['goods_name'];
                        $attr[$k . $k1]['price'] = $v1['price'];
                        $attr[$k . $k1]['parent_name'] = $v['goods_name'];
                        $attr[$k . $k1]['sever_time'] = sever_time($v1['sever_time']);
                    }
                }
            }
            return array_values($attr);
        } else {
            return false;
        }
    }

    /**
     * 根据大类id获取子类
     * @param $merchant_id
     * @param $pid
     * @return array|bool
     */
    public function goodsCateByPid($merchant_id, $pid)
    {
        $child_obj = $this->model
            ->where('pid', $pid)
            ->where('merchant_id', $merchant_id)
            ->select('id', 'goods_name', 'sever_time', 'price')
            ->get();
        if (count($child_obj) !== 0) {
            $attr = array();
            $arr = $child_obj->toArray();
            foreach ($arr as $k => $v) {
                $attr[$k]['id'] = $v['id'];
                $attr[$k]['goods_name'] = $v['goods_name'];
                $attr[$k]['price'] = $v['price'];
                $attr[$k]['sever_time'] = sever_time($v['sever_time']);
                $attr[$k]['parent_name'] = $this->model
                    ->where('id', $pid)
                    ->where('merchant_id', $merchant_id)
                    ->value('goods_name');
            }
            return $attr;
        } else {
            return false;
        }
    }

    /**
     * 根据子类id获取项目数据（预约项目）
     * @param $merchant_id
     * @param $goods_id
     * @return bool
     */
    public function goodsCateById($merchant_id, $goods_id)
    {
        $child_obj = $this->model
            ->where('id', $goods_id)
            ->where('merchant_id', $merchant_id)
            ->select('id', 'goods_name', 'sever_time', 'price', 'pid')
            ->first();
        if (count($child_obj) !== 0) {
            $arr = $child_obj->toArray();
            $arr['parent_name'] = $this->model
                ->where('id', $arr['pid'])
                ->value('goods_name');
            $arr['sever_time'] = sever_time($arr['sever_time']);
            return $arr;
        } else {
            return false;
        }
    }


    /**
     * 根据服务师id获取 产品大类
     * @param $waiter_id
     * @return bool
     */
    public function parentByWaiterId($waiter_id)
    {
        $goods_id = DB::table('wr_waiter_goods')
            ->where('waiter_id', $waiter_id)
            ->pluck('goods_id');
        if ($goods_id) {
            $parent_id = $this->model
                ->whereIn('id', $goods_id)
                ->where('level', 1)
                ->pluck('pid');
            $arr = $this->model
                ->whereIn('id', $parent_id)
                ->select('id', 'goods_name')
                ->get()->toArray();
            return $arr;
        } else {
            return false;
        }

    }

    /**
     * 根据服务师id获取 产品子类
     * @param $waiter_id
     * @return array|bool
     */
    public function goodsCateByWaiterId($waiter_id)
    {
        $goods_id = DB::table('wr_waiter_goods')
            ->where('waiter_id', $waiter_id)
            ->pluck('goods_id');
        $obj = $this->model
            ->whereIn('id', $goods_id)
            ->where('level', 1)
            ->select('id', 'goods_name', 'sever_time', 'price', 'pid')
            ->get();
        if (count($obj) !== 0) {
            $attr = array();
            $parent_arr = $obj->toArray();
            foreach ($parent_arr as $k => $v) {
                $attr[$k]['pid'] = $v['pid'];
                $attr[$k]['id'] = $v['id'];
                $attr[$k]['goods_name'] = $v['goods_name'];
                $attr[$k]['price'] = $v['price'];
                $attr[$k]['parent_name'] = $this->model
                    ->where('id', $v['pid'])
                    ->value('goods_name');
                $attr[$k]['sever_time'] = sever_time($v['sever_time']);

            }
            //排序
            usort($attr, function ($a, $b) {
                $al = $a['pid'];
                $bl = $b['pid'];
                if ($al == $bl)
                    return 0;
                return ($al > $bl) ? 1 : -1;
            });
            return $attr;
        } else {
            return false;
        }
    }

    /**
     * 据服务师id,产品pid 获取产品子类
     * @param $pid
     * @param $waiter_id
     * @return bool
     */
    public function goodsCateByWaiterIdByPid($pid, $waiter_id)
    {
        //根据服务师id获取服务师下面的产品子id
        $waiter_goods_id = DB::table('wr_waiter_goods')
            ->where('waiter_id', $waiter_id)
            ->pluck('goods_id');
        //根据pid获取所有的产品子id
        $pid_goods_id = $this->model
            ->where('pid', $pid)
            ->where('level', 1)
            ->pluck('id')
            ->toArray();
        //获取两者的交集
        $goods_id = array_intersect($waiter_goods_id, $pid_goods_id);

        if (!empty($goods_id)) {
            $goods_obj = $this->model
                ->whereIn('id', $goods_id)
                ->where('level', 1)
                ->select('id', 'goods_name', 'sever_time', 'price', 'pid')
                ->get();
            if ($goods_obj) {
                $goods_arr = $goods_obj->toArray();
                foreach ($goods_arr as $k => &$v) {
                    $v['sever_time'] = sever_time($v['sever_time']);
                    $v['parent_name'] = $this->model
                        ->where('id', $v['pid'])
                        ->value('goods_name');
                }
                return $goods_arr;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }
}

