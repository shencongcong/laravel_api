<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\Admin\ActionButtonTrait;

class WaiterLevel extends Model implements Transformable
{
    use TransformableTrait;
    use ActionButtonTrait;
    protected $table = 'wr_waiter_level';
    protected $fillable = [
        'name',
        'merchant_id',
    ];

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
