<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\Admin\ActionButtonTrait;

use Illuminate\Database\Eloquent\SoftDeletes;

class Appoint extends Model implements Transformable
{
    use TransformableTrait;
    use ActionButtonTrait;
    use SoftDeletes;

    protected $table = 'wr_appoint';


    /*
     * 可以被批量赋值的属性.
     * */
    protected $fillable = [
        'merchant_id',
        'shop_id',
        'waiter_id',
        'member_id',
        'goods_id',
        'time_date',
        'tel',
        'remark',
        'time_hour',
        'time_str',
        'appoint_id'
    ];

    /**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = [];

    //软删除
    protected $dates = ['deleted_at'];

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

    /**
     * 获取当前时间
     *
     * @return int
     */
    public function freshTimestamp() {
        return time();
    }
}
