<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:21
 */

namespace App\Api\Controllers\Merchant;

use App\Api\Controllers\ApiBaseController;
use App\Api\Transformer\MemberTransformer;
use Illuminate\Http\Request;
use App\Repositories\Contracts\MemberRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class MemberController
 * @package App\Api\Controllers
 */
class MemberController extends ApiBaseController
{
    protected $memberTransformer;
    private $member;

    public function __construct(MemberRepository $memberRepository, MemberTransformer $memberTransformer)
    {
        $this->member = $memberRepository;
        $this->memberTransformer = $memberTransformer;
    }

    /**
     * @GET
     * 展示所有的会员
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() 
    {
        $merchant_id = $this->getMesByToken()['merchant_id'];
        $member_arr = $this->member->memberList($merchant_id);
        if ($member_arr && $member_arr !== 204 && $member_arr !== 406) {
            return $this->successResponse(200, '成功', $this->memberTransformer->merchantTransformer($member_arr));
        } elseif ($member_arr == 204) {
            return $this->errorResponse(204, '暂无客户');
        } else {
            return $this->errorResponse(406, '数据异常');
        }
    }






}