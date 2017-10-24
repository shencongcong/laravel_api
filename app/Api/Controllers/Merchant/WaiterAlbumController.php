<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:21
 */

namespace App\Api\Controllers\Merchant;

use App\Api\Controllers\ApiBaseController;
use App\Api\Transformer\WaiterAlbumTransformer;
use App\models\Waiter;
use Illuminate\Http\Request;
use App\Repositories\Contracts\WaiterAlbumRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class WaiterAlbumController
 * @package App\Api\Controllers
 */
class WaiterAlbumController extends ApiBaseController
{
    private $waiterAlbum;
    protected $albumTransformer;

    public function __construct(WaiterAlbumRepository $albumRepository, WaiterAlbumTransformer $albumTransformer)
    {
        $this->waiterAlbum = $albumRepository;
        $this->albumTransformer = $albumTransformer;
    }

    /**
     * @GET
     * 所有作品显示
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $album = $this->waiterAlbum->Index($merchant_id);
        //dd($album);
        if ($album) {
            foreach ($album as $k => &$value) {
                $shop_name = DB::table('wr_shop')->where('id', $value['shop_id'])->value('shop_name');
                $waiter_name = DB::table('wr_waiter')->where('id', $value['waiter_id'])->value('nickname');
                $created_time = date('Y-m-d', $value['created_at']);
                $value['shop_name'] = $shop_name;
                $value['waiter_name'] = $waiter_name;
                $value['created_time'] = $created_time;
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
            }
            return $this->successResponse(200, '成功', $this->albumTransformer->transformer($album));
        } else {
            return $this->errorResponse(204, '失败');
        }
    }

    /**
     * @GET
     * 作品显示
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $id = $request->input('id');
        if (empty($id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $attr = $this->waiterAlbum->show($id);
        if ($attr) {
            $attr['shop_name'] = DB::table('wr_shop')
                ->where('id', $attr['shop_id'])
                ->value('shop_name');
            $waiter_arr = Waiter::where('id', $attr['waiter_id'])
                ->select('nickname', 'img', 'level')
                ->first();
            if ($waiter_arr) {
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
            $attr['created_time'] = date('Y-m-d', $attr['created_at']);
            $album = array(
                $attr['img_back'], $attr['img_right'],
                $attr['img_left'], $attr['img_front'],);
            foreach ($album as $k1 => $v1) {
                if (empty($v1)) {
                    unset($album[$k1]);
                }
            }
            $attr['img'] = array_merge($album);
            return $this->successResponse(200, '成功', $this->albumTransformer->oneTransformer($attr));
        } else {
            return $this->errorResponse(406, '失败');
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
        if (empty($id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $res = $this->waiterAlbum->destroy($id);
        if ($res) {
            return $this->successResponse(200, '成功');
        } else {
            return $this->errorResponse(406, '失败');
        }
    }

}