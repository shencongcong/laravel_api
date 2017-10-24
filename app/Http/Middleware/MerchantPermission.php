<?php

namespace App\Http\Middleware;

use App\Api\Controllers\ApiBaseController;
use Closure;
use DB;

class MerchantPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$m)
    {
        $merchant_id = ApiBaseController::getMesByToken()['merchant_id'];
        $permissions = DB::table('wr_merchant')
            ->where('wr_merchant.id','=',$merchant_id)
            ->join('wr_merchant_role_permission','wr_merchant.role','=','wr_merchant_role_permission.role_id')
            ->join('wr_merchant_permission','wr_merchant_permission.id','=','wr_merchant_role_permission.permission_id')
            ->select('wr_merchant_permission.name')
            ->get();
        $permission_arr = [];
        foreach ($permissions as $permission) {
            array_push($permission_arr,$permission->name);
        }
        //dd(in_array($m, $permission_arr));
        if(!in_array($m, $permission_arr)){
            abort(403,'没有权限！');
        }
        return $next($request);
    }
}
