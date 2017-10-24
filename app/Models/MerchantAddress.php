<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\Admin\ActionButtonTrait;

use Illuminate\Database\Eloquent\SoftDeletes;

class MerchantAddress extends Model implements Transformable
{
    use TransformableTrait;
    use ActionButtonTrait;
    use SoftDeletes;

    protected $table = 'wr_merchant_address';



    /*
     * 可以被批量赋值的属性.
     * */
    protected $fillable = [
        'id',
        'tel',
        'address',
        'merchant_id',
        'remark',
        'apply_num',
        'is_send',
        'name'
    ];

    /**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = [];


    public function freshTimestamp() {
    return time();
}

    public function fromDateTime($value) {
        return $value;
    }

    public function getDateFormat() {
        return 'U';
    }

}
