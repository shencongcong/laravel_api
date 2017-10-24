<?php

namespace App\Repositories\Eloquent;

use App\Models\MerchantPermission;
use App\Repositories\Contracts\MerchantPermissionRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class MenuRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class MerchantPermissionRepositoryEloquent extends BaseRepository implements MerchantPermissionRepository
{
    /**
     * Specify Model class name
     * @return string
     */
    public function model()
    {
        return MerchantPermission::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getAll()
    {
        $list = $this->paginate();
        $items = $list->toArray();
        foreach ($items['data'] as $key => $value) {
            $items['data'][$key]['button'] = $this->model->getActionButtons('merchantPermission',$value['id']);
        }
        $data['data'] = $items['data'];
        $data['page'] = $list;
        return $data;
    }
}
