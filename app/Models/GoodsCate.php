<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\Admin\ActionButtonTrait;



class GoodsCate extends Model implements Transformable
{
    use TransformableTrait;
    use ActionButtonTrait;

    protected $table = 'wr_goods_cate';


    /*
     * 可以被批量赋值的属性.
     * */
    protected $fillable = [
        'goods_name',
        'pid',
        'sort',
        'merchant_id',
        'level',
        'price',
        'sever_time',
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
