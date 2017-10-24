<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\MerchantRoleRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\MerchantRoleRepositoryEloquent;
use App\Repositories\Eloquent\MerchantPermissionRepositoryEloquent;
use Log;

class MerchantRoleController extends Controller
{
    public $merchantRole;
    public $merchantPermission;
    public function __construct(MerchantRoleRepositoryEloquent $merchantRoleRepository,MerchantPermissionRepositoryEloquent $merchantPermission)
    {
        $this->middleware('CheckPermission:merchantRole');
        $this->merchantRole = $merchantRoleRepository;
        $this->merchantPermission = $merchantPermission;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas= $this->merchantRole->getAll();
        return view('admin.merchantRole.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = $this->merchantPermission->all(['id','display_name']);
        return view('admin.merchantRole.create',compact('permission'));
    }

    public function store(MerchantRoleRequest $request)
    {
        //dd($request->all());
        Log::info('MerchantRoleRequest.store');
        $this->merchantRole->createRole($request->all());
        return redirect('admin/merchantRole');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = $this->merchantRole->editViewData($id);
        return view('admin.merchantRole.edit',compact('data'));
    }

    public function update(MerchantRoleRequest $request, $id)
    {
        $this->merchantRole->updateRole($request->all(),$id);
        return redirect('admin/merchantRole');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = $this->merchantRole->delete($id);
        if ($res) {
            flash('删除成功', 'success');
        } else {
            flash('删除失败', 'error');
        }
        return redirect('admin/merchantRole');
    }

}
