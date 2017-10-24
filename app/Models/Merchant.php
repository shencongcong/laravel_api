<?php

namespace App\Models;

use App\Traits\Admin\ActionButtonTrait;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use ActionButtonTrait;

    protected $table = 'wr_merchant';

    protected $fillable = [
		'merchant_name',
        'role',
		'expire',
		'shop_nums',
		'qr_code_waiter',
		'logo',
		'public_id',
		'qr_code_member',
		'status',
        'introduce'
	];

	/**
	 * 获取当前时间
	 *
	 * @return int
	 */
	public function freshTimestamp() {
		return time();
	}

	/**
	 * 避免转换时间戳为时间字符串
	 *
	 * @param DateTime|int $value
	 * @return DateTime|int
	 */
	public function fromDateTime($value) {
		return $value;
	}

	/**
	 * 从数据库获取的为获取时间戳格式
	 *
	 * @return string
	 */
	public function getDateFormat() {
		return 'U';
	}

}
