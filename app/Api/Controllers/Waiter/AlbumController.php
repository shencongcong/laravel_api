<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:21
 */

namespace App\Api\Controllers\Waiter;

use App\Api\Controllers\ApiBaseController;
use App\Api\Transformer\WaiterAlbumTransformer;
use Illuminate\Http\Request;
use App\Repositories\Contracts\WaiterAlbumRepository;
use Illuminate\Support\Facades\DB;
use Cache;
use Config;

/**
 * Class WaiterAlbumController
 * @package App\Api\Controllers
 */
class AlbumController extends ApiBaseController
{
    private $album;
    protected $albumTransformer;

    public function __construct(WaiterAlbumRepository $albumRepository, WaiterAlbumTransformer $albumTransformer)
    {
        $this->album = $albumRepository;
        $this->albumTransformer = $albumTransformer;
    }

    /**
     * @GET
     * 所有作品显示
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $waiter_id = $this->getMesByToken()['id'];
        //缓存
        $res = Cache::get('WaiterAlbumRepositoryEloquent_albumIndex' . $waiter_id);
        if ($res) {
            return $this->successResponse(200, '成功', $res);
        } else {
            $album = $this->album->albumIndex($waiter_id);
            if ($album) {
                Cache::put('WaiterAlbumRepositoryEloquent_albumIndex' . $waiter_id, $album, Config::get('constants.ONE_MINUTE'));
                return $this->successResponse(200, '成功', $album);
            } else {
                return $this->errorResponse(204, '暂无作品');
            }
        }

    }

    /**
     * @GET
     * 作品编辑展示
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request)
    {
        $id = $request->input('id');
        if (empty($id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $arr = $this->album->edit($id);
        if ($arr) {
            $img = array($arr['img_front'], $arr['img_left'], $arr['img_right'], $arr['img_back']);
            foreach ($img as $k => $value) {
                switch ($k) {
                    case '0':
                        $album['img']['img0'] = $value;
                        break;
                    case '1':
                        $album['img']['img1'] = $value;
                        break;
                    case '2':
                        $album['img']['img2'] = $value;
                        break;
                    case '3':
                        $album['img']['img3'] = $value;
                        break;
                }
            }
            $album['name'] = $arr['name'];
            $album['introduce'] = $arr['introduce'];
            return $this->successResponse(200, '成功', $album);
        } else {
            return $this->errorResponse(406, '失败');
        }
    }

    /**
     * @GET
     * 单个作品显示
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $id = $request->input('id');
        if (empty($id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        //缓存
        $res = Cache::get('WaiterAlbumRepositoryEloquent_show' . $id);
        if ($res) {
            return $this->successResponse(200, '成功', $this->albumTransformer->oneTransformer($res));
        } else {
            $attr = $this->album->show($id);
            if ($attr) {
                Cache::put('WaiterAlbumRepositoryEloquent_show' . $id, $attr, Config::get('constants.ONE_MINUTE'));
                return $this->successResponse(200, '成功', $this->albumTransformer->oneTransformer($attr));
            } else {
                return $this->errorResponse(406, '失败');
            }
        }
    }

    /**
     * @DELETE
     * 作品删除
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $waiter_id = $this->getMesByToken()['id'];
        if (empty($id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $res = $this->album->destroy($id);
        if ($res) {
            Cache::forget('WaiterAlbumRepositoryEloquent_show' . $id);
            Cache::forget('WaiterAlbumRepositoryEloquent_albumIndex' . $waiter_id);
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(406, '失败');
        }
    }

    /**
     * @POST
     * 作品添加
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $waiter_id = $this->getMesByToken()['id'];
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $attr = $this->dealRequest($request->except('img'));
        $img = $request->input('img');
        //$img = json_decode($request->input('img'));
        $shop_id = DB::table('wr_waiter')
            ->join('wr_shop_waiter', 'wr_shop_waiter.waiter_id', '=', 'wr_waiter.id')
            ->join('wr_shop', 'wr_shop.id', '=', 'wr_shop_waiter.shop_id')
            ->where('wr_waiter.id', $waiter_id)
            ->pluck('wr_shop.id');
        if (empty($attr['introduce']) || empty($attr['name'])) {
            return $this->errorResponse(405, '缺少必要的参数');
        }
        if (count($shop_id) > 1) {
            $attr['shop_id'] = implode(',', $shop_id);
        } else {
            $attr['shop_id'] = $shop_id[0];
        }
        foreach ($img as $k => $value) {
            switch ($k) {
                case 'img0':
                    $attr['img_front'] = $value;
                    break;
                case 'img1':
                    $attr['img_left'] = $value;
                    break;
                case 'img2':
                    $attr['img_right'] = $value;
                    break;
                case 'img3':
                    $attr['img_back'] = $value;
                    break;
            }
        }
        $attr['waiter_id'] = $waiter_id;
        $attr['merchant_id'] = $merchant_id;
        $res = $this->album->store($attr);
        if ($res) {
            Cache::forget('WaiterAlbumRepositoryEloquent_albumIndex' . $waiter_id);
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(406, '失败');
        }
    }

    /**
     * @POST
     * 作品数据提交
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $waiter_id = $this->getMesByToken()['id'];
        $attr = $this->dealRequest($request->except('img', 'id'));
        //$img = $request->input('img');
        $img = $request->input('img');
        $album_id = $request->input('id');
        if (empty($attr['introduce']) || empty($attr['name'])) {
            return $this->errorResponse(405, '缺少必要的参数');
        }
        foreach ($img as $k => $value) {
            switch ($k) {
                case 'img0':
                    $attr['img_front'] = $value;
                    break;
                case 'img1':
                    $attr['img_left'] = $value;
                    break;
                case 'img2':
                    $attr['img_right'] = $value;
                    break;
                case 'img3':
                    $attr['img_back'] = $value;
                    break;
            }
        }
        $res = $this->album->waiterAlbumUpdate($album_id, $attr);
        if ($res) {
            Cache::forget('WaiterAlbumRepositoryEloquent_show' . $album_id);
            Cache::forget('WaiterAlbumRepositoryEloquent_albumIndex' . $waiter_id);
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(406, '失败');
        }
    }
}