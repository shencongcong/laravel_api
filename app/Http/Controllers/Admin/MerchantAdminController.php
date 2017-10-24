<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MerchantAdminRequest;
use App\Repositories\Contracts\MerchantAdminRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\MerchantRepository;
Use Log;
use Route;

class MerchantAdminController extends Controller
{
    private $merchantAdmin;
    private $merchant;

    public function __construct(MerchantAdminRepository $merchantAdminRepository, MerchantRepository $merchantRepository)
    {
        $this->merchantAdmin = $merchantAdminRepository;
        $this->merchant = $merchantRepository;
        //$this->middleware('CheckPermission:merchantAdmin');

        // store方法
/*        $route = Route::currentRouteName();
        Log::info($route);
        if($route == 'admin.MerchantAdmin.store'){
            dd(1);
            $request = new MerchantAdminRequest();
            Log::info($request->all());
            $this->merchantAdmin->createMerchantAdmin($request->all());
            return redirect('admin/merchantAdmin');
        }*/
    }

    public function index()
    {
        $merchantAdmin = $this->merchantAdmin->getAll();
        foreach ($merchantAdmin['data'] as $k => $v) {
            $merchantAdmin['data'][$k]['merchant_name'] = $this->merchant->findWhere(['id' => $v['merchant_id']], ['merchant_name'])->toArray();
        }
        return view('admin.merchantAdmin.index', compact('merchantAdmin'));
    }

    public function create()
    {
        $merchant = $this->merchant->all(['id', 'merchant_name']);
        return view('admin.merchantAdmin.create', compact('merchant'));
    }

    public function store(MerchantAdminRequest $request)
    {
        $this->merchantAdmin->createMerchantAdmin($request->all());
        return redirect('admin/merchantAdmin');
    }


    public function update(MerchantAdminRequest $request, $id)
    {
        // TODO 后期增加密码的修改逻辑
        $res = $this->merchantAdmin->update($request->all(), $id);
        if ($res) {
            flash('商户更新成功', 'success');
        } else {
            flash('商户更新失败', 'error');
        }
        return redirect('admin/merchantAdmin');
    }

    public function edit($id)
    {
        $merchant = $this->merchant->all(['id', 'merchant_name']);
        $merchantAdmin = $this->merchantAdmin->find($id)->toArray();
        return view('admin.merchantAdmin.edit', compact('merchant', 'merchantAdmin'));
    }

    public function destroy($id)
    {
        $res = $this->merchantAdmin->delete($id);
        if ($res) {
            flash('商户管理员删除成功', 'success');
        } else {
            flash('商户管理员删除失败', 'error');
        }
        return redirect('admin/merchantAdmin');
    }
}
