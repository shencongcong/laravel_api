<?php

namespace App\Repositories\Eloquent;

use App\Models\PublicNum;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\PublicRepository as PublicRepository;

class PublicRepositoryEloquent extends BaseRepository implements PublicRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PublicNum::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

	public function getAll($columns = ['*'])
	{
        $list = PublicNum::where('is_bind','=',1)->paginate();
        $items = $list->toArray();
  /*      foreach ($items['data'] as $key => $value) {
            $items['data'][$key]['button'] = $this->model->deleteButton('public',$value['id']);
        }*/
        $data['data'] = $items['data'];
        $data['page'] = $list;
        return $data;
	}
}
