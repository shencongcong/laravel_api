<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Admin\ActionButtonTrait;
class MerchantRole extends Model
{
    use ActionButtonTrait;

    protected $table = 'wr_merchant_role';
    protected $fillable = [
        'display_name',
        'name',
        'description'
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
     * select的时候避免转换时间为Carbon
     *
     * @param mixed $value
     * @return mixed
     */
//  protected function asDateTime($value) {
//      return $value;
//  }

    /**
     * 从数据库获取的为获取时间戳格式
     *
     * @return string
     */
    public function getDateFormat() {
        return 'U';
    }

/*    public function admins ()
    {
        // 多对多的关系（一个角色赋予了多个用户）
        return $this->belongsToMany(Admin::class,'admins','id');
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class,'permission_role');
    }*/
}