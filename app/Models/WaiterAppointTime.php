<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\Admin\ActionButtonTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class WaiterAppointTime extends Model implements Transformable
{
    use TransformableTrait;
    use ActionButtonTrait;
    use SoftDeletes;

    protected $table = 'wr_waiter_appoint_time';

    public $timestamps = false;


    /*
     * 可以被批量赋值的属性.
     * */
    protected $fillable = [
        'waiter_id',
        'merchant_id',
        'shop_id',
        'time_date',
        'sort_id',
        'appoint_id',
        'status',

    ];

    /**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = [];

}
