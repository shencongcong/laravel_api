<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Wechat\BaseController;
use Illuminate\Http\Request;

class UserController extends BaseController
{

    /**
     * @get 获取所有用户openid
     * @return \EasyWeChat\Support\Collection
     */
    public function user()
    {
        $user = $this->apps->user->lists($nextOpenId = null);
        return $user;
    }

    /**
     * @get 根据openid 获取单个用户信息
     * @param \Illuminate\Http\Request $request
     * @return \EasyWeChat\Support\Collection
     */
    public function show(Request $request)
    {
        $openId = $request->get('openId');
        $user = $this->apps->user->get($openId);
        return $user;
    }

    public function shows(Request $request)
    {
        $openIds = $request->get('openIds');
        $openIds_arr = unserialize($openIds);
        $users = $this->apps->user->batchGet($openIds_arr);
        return $users;
    }


}