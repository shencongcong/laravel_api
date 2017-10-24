<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:21
 */

namespace App\Api\Controllers\Member;

use App\Api\Controllers\ApiBaseController;
use App\Api\Transformer\AppointTransformer;
use App\Repositories\Eloquent\ShopRepositoryEloquent;
use Illuminate\Http\Request;
use App\Repositories\Contracts\AppointRepository;
use Illuminate\Support\Facades\DB;


class PublicController extends ApiBaseController
{
    private $appoint;
    protected $appointTransformer;

    public function __construct(AppointRepository $appointRepository, AppointTransformer $appointTransformer)
    {
        $this->appoint = $appointRepository;
        $this->appointTransformer = $appointTransformer;
    }

    public function shopIndex(Request $request, ShopRepositoryEloquent $shopRepositoryEloquent)
    {
        $shop_id = $this->dealRequest($request->only('shop_id'));
        $shop_arr = $shopRepositoryEloquent->indexByShopId($shop_id);
        
        
    }
}

