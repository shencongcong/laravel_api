<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\Admin\ActionButtonTrait;

//use Illuminate\Database\Eloquent\SoftDeletes;

class WaiterAlbum extends Model implements Transformable
{
    use TransformableTrait;
    use ActionButtonTrait;
    //use SoftDeletes;

    protected $table = 'wr_waiter_album';


    /*
     * 可以被批量赋值的属性.
     * */
    protected $fillable = [
        'name',
        'introduce',
        'shop_id',
        'merchant_id',
        'img_front',
        'img_left',
        'img_right',
        'img_back',
        'waiter_id',
    ];

    /**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = [];

    //软删除
    //protected $dates = ['deleted_at'];


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
