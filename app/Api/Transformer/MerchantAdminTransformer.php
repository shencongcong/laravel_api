<?php


namespace App\Api\Transformer;


use League\Fractal\TransformerAbstract;

class MerchantAdminTransformer extends TransformerAbstract
{
	//首页信息展示
	public function transform($data)
	{
		return [
			'nickname' => $data['nickname'],
			'img' => $data['img'],
		];
	}

	//管理员详细信息
	public function transformShow($data)
	{
		return [
			'nickname' => $data['nickname'],
			'img' => $data['img'],
			'admin_tel' =>$data['admin_tel']
		];
	}
}