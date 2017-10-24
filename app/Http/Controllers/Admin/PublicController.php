<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\PublicRepository;
use EasyWeChat\Foundation\Application;
use DB;

class PublicController extends Controller
{
    private $public;

    /**
     * PublicController constructor.
     * @param $public
     */
    public function __construct(PublicRepository $publicRepository)
    {
        $this->public = $publicRepository;
        $this->middleware('CheckPermission:public');
    }

    public function index()
    {
        $public = $this->public->getAll();
        foreach ($public['data'] as $k => $v) {
            $public['data'][$k]['wx_user_num'] = DB::table('wr_wuser')->where(['token'=>$v['token']])->count('*');
    }
        return view('admin.public.index',compact('public'));
    }

    public function create()
    {
        $options = config('wechat');
        $app = new Application($options);
        $openPlatform = $app->open_platform;
        $openPlatform->pre_auth->getCode();
        $backCall = url('wechat/openPlatform/callBack');
        $response = $openPlatform->pre_auth->redirect($backCall);
        return redirect($response->getTargetUrl());
        //var_dump($response->getTargetUrl());
    }

    public function destroy($id)
    {
        // 真正解决绑定需要在公众号里面接触授权
        $res = $this->public->where('id',$id)->update(['is_bind'=>0]);
        if ($res){
            flash('删除成功','success');
        }else{
            flash('删除失败','error');
        }
        return redirect('admin/public');
    }
}
