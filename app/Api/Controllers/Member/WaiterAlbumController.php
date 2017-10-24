<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:21
 */

namespace App\Api\Controllers\Member;

use App\Api\Controllers\ApiBaseController;
use App\Api\Transformer\WaiterAlbumTransformer;
use Illuminate\Http\Request;
use App\Repositories\Contracts\WaiterAlbumRepository;
use Illuminate\Support\Facades\DB;


/**
 * Class WaiterAlbumController
 * @package App\Api\Controllers\Member
 */
class WaiterAlbumController extends ApiBaseController
{
    private $album;
    protected $albumTransformer;

    public function __construct(WaiterAlbumRepository $albumRepository, WaiterAlbumTransformer $transformer)
    {
        $this->album = $albumRepository;
        $this->albumTransformer = $transformer;
    }

    /**
     * 服务师所有的作品
     * @GET
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function allAlbum(Request $request)
    {
        $waiter_id = $request->input('waiter_id');
        if (empty($waiter_id)) {
            return $this->errorResponse(405, '请求缺少必要参数');
        }
        $album = $this->album->allAlbum($waiter_id);
        if ($album) {
            $attr = array();
            foreach ($album as $k => $v) {
                $attr[$k]['id'] = $v['id'];
                $attr[$k]['name'] = $v['name'];
                $attr[$k]['waiter_img'] = DB::table('wr_waiter')
                    ->where('id', $waiter_id)
                    ->value('img');
                $img = array(
                    $v['img_front'], $v['img_right'],
                    $v['img_left'], $v['img_back'],
                );
                $album_img = array_filter($img);
                $attr[$k]['img'] = array_merge($album_img);

            }
            return $this->successResponse(200, '成功', $attr);
        } else {
            return $this->errorResponse(204, '暂无内容');
        }
    }

    /**
     * 服务师作品详情
     * @GET
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function albumShow(Request$request)
    {
        $album_id = $request->input('album_id');
        $arr = $this->album->show($album_id);
        if($arr){
            return $this->successResponse(200, '成功', $this->albumTransformer->oneTransformer($arr));
        }else{
            return $this->errorResponse(406, '失败');
        }
    }
}

