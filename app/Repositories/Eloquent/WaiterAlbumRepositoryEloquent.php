<?php

namespace App\Repositories\Eloquent;

use App\models\Waiter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

use App\Repositories\Contracts\WaiterAlbumRepository as WaiterAlbumRepositoryInterface;
use App\Models\WaiterAlbum;
use DB;

/**
 * Class WaiterAlbumRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class WaiterAlbumRepositoryEloquent extends BaseRepository implements WaiterAlbumRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WaiterAlbum::class;
    }

    //商户端
    /**
     * 商户所有作品显示
     * @param $merchant_id
     * @return array|bool
     */
    public function Index($merchant_id)
    {

        $arr_obj = DB::table('wr_waiter_album')
            ->leftjoin('wr_waiter', 'wr_waiter.id', '=', 'wr_waiter_album.waiter_id')
            ->where(['wr_waiter.merchant_id' => $merchant_id, 'wr_waiter.deleted_at' => null])
            ->select('wr_waiter_album.*')
            ->get();
        if ($arr_obj) {
            $arr = array_map('get_object_vars', $arr_obj);
            return $arr;
        } else {
            return false;
        }
    }

    /**
     * 作品展示
     * @param $album_id
     * @return bool|mixed
     */
    public function show($album_id)
    {
        $res = $this->model->where('id', $album_id)->first();
        if (count($res) !== 0) {
            $attr = $res->toArray();
            $shop_id = explode(',', $attr['shop_id']);
            $attr['shop_name'] = DB::table('wr_shop')
                ->whereIn('id', $shop_id)
                ->pluck('shop_name');
            $waiter_obj = Waiter::where('id', $attr['waiter_id'])
                ->select('nickname', 'img', 'level')
                ->first();
            if (count($waiter_obj) !== 0) {
                $waiter_arr = $waiter_obj->toArray();
                $attr['waiter_name'] = $waiter_arr['nickname'];
                $attr['waiter_img'] = $waiter_arr['img'];
                $attr['level_name'] = DB::table('wr_waiter_level')
                    ->where('id', $waiter_arr['level'])
                    ->value('name');
            } else {
                $attr['waiter_name'] = null;
                $attr['waiter_img'] = null;
                $attr['level_name'] = null;
            }
            $attr['time'] = date('Y-m-d', $attr['created_at']);
            $album_img = array(
                $attr['img_back'], $attr['img_right'],
                $attr['img_left'], $attr['img_front']);
            foreach ($album_img as $k1 => $v1) {
                if (empty($v1)) {
                    unset($album_img[$k1]);
                }
            }
            $attr['img'] = array_merge($album_img);
            return $attr;
        } else {
            return false;
        }
    }

    /**
     * 服务师作品编辑展示
     * @param $album_id
     * @return bool
     */
    public function edit($album_id)
    {
        $res = $this->model->where('id', $album_id)
            ->select('name', 'introduce', 'img_front', 'img_left', 'img_right', 'img_back')
            ->first();
        if (count($res) !== 0) {
            $attr = $res->toArray();
            $album = array();
            $album_img = array(
                $attr['img_back'], $attr['img_right'],
                $attr['img_left'], $attr['img_front']);
            foreach ($album_img as $k1 => $v1) {
                if (empty($v1)) {
                    unset($album_img[$k1]);
                }
            }
            $album['img'] = array_merge($album_img);
            $album['name'] = $attr['name'];
            $album['introduce'] = $attr['introduce'];
            return $attr;
        } else {
            return false;
        }
    }

    /**
     * 作品删除
     * @param $album_id
     * @return bool
     */
    public function destroy($album_id)
    {
        $res = $this->model->where('id', $album_id)->delete();
        if ($res) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * 服务师端作品首页
     * @param $waiter_id
     * @return bool
     */
    public function albumIndex($waiter_id)
    {
        $res = $this->model
            ->where('waiter_id', $waiter_id)
            ->select('id', 'name', 'introduce', 'img_front', 'img_left', 'img_right', 'img_back', 'created_at', 'shop_id')
            ->get();
        if (count($res) !== 0) {
            $album = $res->toArray();
            foreach ($album as $k => &$value) {
                $shop_id = explode(',', $value['shop_id']);
                $value['shop_name'] = DB::table('wr_shop')->whereIn('id', $shop_id)->pluck('shop_name');
                $waiter_arr = DB::table('wr_waiter')->where('id', $waiter_id)->select('nickname', 'img')->first();
                $level_name = DB::table('wr_waiter_level')
                    ->join('wr_waiter', 'wr_waiter.level', '=', 'wr_waiter_level.id')
                    ->where('wr_waiter.id', $waiter_id)
                    ->value('name');
                $time = date('Y-m-d', $value['created_at']);
                unset($album[$k]['created_at']);
                $value['waiter_name'] = $waiter_arr->nickname;
                $value['waiter_img'] = $waiter_arr->img;
                $value['time'] = $time;
                $value['level_name'] = $level_name;
                $attr = array(
                    $value['img_back'], $value['img_right'],
                    $value['img_left'], $value['img_front'],
                );
                foreach ($attr as $k1 => $v1) {
                    if (empty($v1)) {
                        unset($attr[$k1]);
                    }
                }
                $value['img'] = array_merge($attr);
                unset($album[$k]['img_back'], $album[$k]['img_right'], $album[$k]['img_left'], $album[$k]['img_front']);
            }
            return $album;
        } else {
            return false;
        }
    }

    /**
     * 服务师端作品添加
     * @param $attr
     * @return static
     */
    public function store($attr)
    {
        return $this->model->create($attr);
    }

    /**
     * 服务师作品编辑数据提交
     * @param $album_id
     * @param $arr
     * @return mixed
     */
    public function waiterAlbumUpdate($album_id, $arr)
    {
        return $this->model
            ->where('id', $album_id)
            ->update($arr);
    }

    /**
     * 客户端 服务师全部作品
     * @param $waiter_id
     * @return bool
     */
    public function allAlbum($waiter_id)
    {
        $obj = $this->model
            ->where('waiter_id', $waiter_id)
            ->select('id', 'name', 'img_front', 'img_left', 'img_right', 'img_back')
            ->get();
        if (count($obj) !== 0) {
            $album_arr = $obj->toArray();
            return $album_arr;
        } else {
            return false;
        }
    }

}
