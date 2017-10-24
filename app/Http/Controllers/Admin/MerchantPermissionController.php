<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MerchantPermissionRequest;
use App\Repositories\Eloquent\MerchantPermissionRepositoryEloquent as MerchantPermissionRepository;

class MerchantPermissionController extends Controller
{
    public $merchantPermission;

    public function __construct(MerchantPermissionRepository $merchantPermissionRepository)
    {
        $this->middleware('CheckPermission:merchantPermission');
        $this->merchantPermission = $merchantPermissionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas= $this->merchantPermission->getAll();
        return view('admin.merchantPermission.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.merchantPermission.create');
    }


    public function store(MerchantPermissionRequest $request)
    {
        $res = $this->merchantPermission->create($request->all());
        if ($res){
            flash('商户删除成功','success');
        }else{
            flash('商户删除失败','error');
        }
        return redirect('admin/merchantPermission');
    }

    public function show(Request $request)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = $this->merchantPermission->find($id,['id','name','display_name','description'])->toArray();
        return view('admin.merchantPermission.edit',compact('permission'));
    }

    public function update(MerchantPermissionRequest $request, $id)
    {
        $res = $this->merchantPermission->update($request->all(),$id);
        if ($res) {
            flash('修改成功!', 'success');
        } else {
            flash('修改失败!', 'error');
        }
        return redirect('admin/merchantPermission');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = $this->merchantPermission->delete($id);
        if ($res) {
            flash('商户权限删除成功', 'success');
        } else {
            flash('商户权限删除失败', 'error');
        }
        return redirect('admin/merchantPermission');
    }

    public function ajaxIndex(Request $request)
    {
        $result = $this->merchantPermission->ajaxIndex($request);
        return response()->json($result,JSON_UNESCAPED_UNICODE);
    }
}