<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Contracts\MerchantAddressRepository;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\Jobs\SendNoticeCode;

/**
 * Class MerchantController
 * @package App\Http\Controllers\Admin
 */
class MerchantCodeController extends Controller
{
    private $merchantAddress;

	public function __construct(MerchantAddressRepository $merchantAddressRepository)
	{
		$this->merchantAddress = $merchantAddressRepository;
		$this->middleware('CheckPermission:merchantCode');
	}

	public function index()
	{
		$merchantAddress = $this->merchantAddress->getAll();
        foreach ($merchantAddress['data'] as $k=>$v) {
            $merchantAddress['data'][$k]['merchant_name'] = DB::table('wr_merchant')->where(['id'=>$v['merchant_id']])
                ->value('merchant_name');
		}
		return view('admin.merchantCode.index',compact('merchantAddress'));
	}


	public function create()
	{
	}

	public function store()
	{
	}

	public function update(Request $request,$id)
	{
        $attrs = $request->all();
        $attr['is_send'] = $attrs['is_send'];
		$this->merchantAddress->updateMerchantCode($attr,$id);
		$tel = DB::table('wr_merchant_address')->where(['id'=>$id])->value('tel');
		// 贴纸状态改为已寄送时候 发送短信通知用户注意查收
        if($attr['is_send']==2){
            $job = (new SendNoticeCode($tel,$tem='SMS_100220018'));
            $this->dispatch($job);
        }
		return redirect('admin/merchantCode');
	}

	public function edit($id)
	{
		$merchant = $this->merchantAddress->find($id)->toArray();
		return view('admin.merchantCode.edit',compact('merchant'));
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


}
