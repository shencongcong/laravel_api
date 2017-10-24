<?php

namespace App\Http\Controllers\Admin;

use App\Api\Controllers\Tool\QrCodesController;
use zgldh\QiniuStorage\QiniuStorage;
use App\Http\Requests\MerchantRequest;
use App\Repositories\Contracts\MerchantRepository;
use App\Repositories\Contracts\PublicRepository;
use App\Repositories\Contracts\MerchantRoleRepository;
use App\Http\Controllers\Controller;
use DB;
use App\Jobs\SendNoticeCode;
/**
 * Class MerchantController
 * @package App\Http\Controllers\Admin
 */
class MerchantController extends Controller
{
    private $merchant;
	private $public;
	private $merchantRole;

	/**
	 * MerchantController constructor.
	 * @param MerchantRepository $merchantRepository
	 * @param PublicRepository $publicRepository
	 */
	public function __construct(MerchantRepository $merchantRepository, PublicRepository $publicRepository,MerchantRoleRepository $merchantRoleRepository)
	{
		$this->merchant = $merchantRepository;
		$this->public = $publicRepository;
        $this->merchantRole = $merchantRoleRepository;
		$this->middleware('CheckPermission:merchant');
	}

	public function index(QrCodesController $qrCodesController)
	{
		$merchant = $this->merchant->getAll();
        foreach ($merchant['data'] as $k => $v) {
            $public_name = $this->public->findWhere(['id'=>$v['public_id']],['public_name'])->toArray();
            $merchant['data'][$k]['public_name'] = $public_name?$public_name[0]['public_name']:'';
            $role = $this->merchantRole->findWhere(['id'=>$v['role']],['display_name'])->toArray();
            $merchant['data'][$k]['role'] = $role?$role[0]['display_name']:'';
            $merchant['data'][$k]['code'] =  $qrCodesController->create(config('constants.MEMBER_REGISTER').'?merchant_id='.$v['id'],100);
            $merchant['data'][$k]['code_big'] =  $qrCodesController->createThreeSize(config('constants.MEMBER_REGISTER').'?merchant_id='.$v['id'],500);
            $merchant['data'][$k]['member_num'] = DB::table('wr_member')->where(['merchant_id'=>$v['id']])->count('*');
		}
//		dd($merchant);
		return view('admin.merchant.index',compact('merchant'));
	}


	public function create()
	{
		$public = $this->public->findWhere(['is_bind'=>1],['id','public_name']);
        $role = $this->merchantRole->all(['id','display_name']);
		return view('admin.merchant.create',compact('public','role'));
	}

	public function store(MerchantRequest $request)
	{
        $attr = $request->except('_token');
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filePath = $request->upload($file);
            $attr['logo'] = $filePath;
        }
		$this->merchant->createMerchant($attr);
		return redirect('admin/merchant');
	}

	public function update(MerchantRequest $request,$id)
	{
        $attr = $request->all();
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filePath = $request->upload($file);
            $attr['logo'] = $filePath;
        }else{
            unset($attr['logo']);
        }
		//获取商户之前的状态
		$status = DB::table('wr_merchant')
			->where('id',$id)
			->value('status');
		//商户更新
		$this->merchant->updateMerchant($attr,$id);
		$arr = DB::table('wr_merchant')
			->join('wr_merchant_admin','wr_merchant_admin.merchant_id','=','wr_merchant.id')
			->where('wr_merchant.id',$id)
			->select('wr_merchant.status','wr_merchant_admin.admin_tel')
			->first();
		//商户状态变成可以使用时发送消息
		if($status == 0 && $arr->status==1){
			$job = (new SendNoticeCode($arr->admin_tel,$tem='SMS_59995659'));
			$this->dispatch($job);
		}
		return redirect('admin/merchant');
	}

	public function edit($id)
	{
        $public = $this->public->findWhere(['is_bind'=>1],['id','public_name']);
        $role = $this->merchantRole->all(['id','display_name']);
		$merchant = $this->merchant->find($id)->toArray();
		return view('admin.merchant.edit',compact('merchant','public','role'));
	}
	
	public function destroy($id)
	{
		$res = $this->merchant->delete($id);
		if ($res){
			flash('商户删除成功','success');
		}else{
			flash('商户删除失败','error');
		}
		return redirect('admin/merchant');
	}

    private function uploadFile($request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $disk = QiniuStorage::disk('qiniu');
            $fileName = md5($file->getClientOriginalName().time().rand()).'.'.$file->getClientOriginalExtension();
            $bool = $disk->put('wr2/image_'.$fileName,file_get_contents($file->getRealPath()));
            if ($bool) {
                $path = $disk->downloadUrl('wr2/image_'.$fileName);
                return $path;
            }
            return ;
        }
    }
}
