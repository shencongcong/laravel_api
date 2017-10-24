<?php

namespace App\Repositories\Eloquent;

use DB;
use App\Models\MerchantPermission;
use App\Models\MerchantRole;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\MerchantRoleRepository as MerchantRoleRepositoryInterface;

/**
 * Class MenuRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class MerchantRoleRepositoryEloquent extends BaseRepository implements MerchantRoleRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MerchantRole::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    public function getAll()
    {
        $list = $this->paginate();
        $items = $list->toArray();
        foreach ($items['data'] as $key => $value) {
            $items['data'][$key]['button'] = $this->model->getActionButtons('merchantRole',$value['id']);
        }
        $data['data'] = $items['data'];
        $data['page'] = $list;
        return $data;
    }

    /**
     * 添加权限
     * @param array $attr
     * @return mixed
     */
    public function createRole(array $attr)
    {
        DB::transaction(function () use ($attr) {
            $role_arr = [];
            $role_arr['name'] =  $attr['name'];
            $role_arr['display_name'] =  $attr['display_name'];
            $role_arr['description'] =  $attr['description'];
            $role_arr['created_at'] =  time();
            $role_arr['updated_at'] =  time();
            $res = DB::table('wr_merchant_role')->insertGetId($role_arr);
            foreach ($attr['permission'] as $item) {
                DB::table('wr_merchant_role_permission')->insert(['role_id'=>$res,'permission_id'=>$item]);
            }
        });
        flash('角色新增成功', 'success');
    }

    /**
     * 编辑页面所需要的数据
     * @param   int     $id
     * @return  array
     */
    public function editViewData($id)
    {
        //$rolePermission = $role->permissions->toArray();
        
        $role = $this->model->find($id,['id','name','display_name','description'])->toArray();
        
        $rolePermissionList = DB::table('wr_merchant_role_permission')->where('role_id',$id)->get(['permission_id']);
        $getRolePermissionClosure = function($permissionList){
            $res = array();
            foreach ($permissionList as $key=>$value) {
                $res[] = $value->permission_id;
            }
            return $res;
        };

        $rolePermission = $getRolePermissionClosure($rolePermissionList);
        
        $permissions = MerchantPermission::all(['id','display_name'])->toArray();

        return compact('role','rolePermission','permissions');
    }

    public function updateRole(array $attr, $id)
    {
        $permissions = $attr['permission'];
        // TODO 优化数据库操作
        unset($attr['permission']);
        $this->update($attr,$id);
        DB::table('wr_merchant_role_permission')->where(['role_id'=>$id])->delete();
        foreach ($permissions as $item) {
            DB::table('wr_merchant_role_permission')->insert(['role_id' => $id, 'permission_id' => $item]);
        }
        flash('修改成功!', 'error');
    }


}
