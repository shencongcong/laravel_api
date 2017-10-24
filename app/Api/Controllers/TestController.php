<?php

namespace App\Api\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Config;
use Tymon\JWTAuth\Facades\JWTFactory;
use Cache;

class TestController extends ApiBaseController
{
    public function index()
    {
        // 缓存使用说明 默认配置 redis缓存
        dd($_REQUEST);
        dd(scc_test());
        $info = $this->getMesByToken();
        return $info;
        Cache::put('key','value',10);  // 10 min
        Cache::get('key');
        // or
        Cache::store('redis')->put('key', 'baz', 10);
        return Cache::store('redis')->get('key');
    }

    public function index1()
    {
        // 读取配置文件方法
        $conf1  = config('constants.WEB_SITE');
        $conf2  = Config::get('constants.MEMBER_LOGIN');
        return 'index1';
    }

    public function memberLogin(){
       // return 1;
        $arr = [
            'data'     => [
                'type' => Config::get('constants.MEMBER_LOGIN'),
                'id' =>1,
                'admin_name' => 'member'
            ]
        ];
        $token = $this->createToken($arr);
        $array = [
            'token'=>$token,
            'id'=>1
        ];
        return $this->successResponse(200, '成功', $array);
    }

}