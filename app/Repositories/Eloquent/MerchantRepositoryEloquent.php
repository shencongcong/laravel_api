<?php

namespace App\Repositories\Eloquent;

use App\Models\Merchant;
use DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\MerchantRepository as MerchantRepository;

class MerchantRepositoryEloquent extends BaseRepository implements MerchantRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Merchant::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getAllI()
    {
        $list = $this->all();
        $items = $list->toArray();
        return $items;
    }

	public function getAll()
	{
		$list = $this->paginate();
		$items = $list->toArray();
		foreach ($items['data'] as $key => $value) {
            $items['data'][$key]['button'] = $this->model->getActionButtons('merchant',$value['id']);
		}
        $data['data'] = $items['data'];
		$data['page'] = $list;
        return $data;
	}

	public function createMerchant(array $attr)
	{
		$attr['expire'] = strtotime($attr['expire']);
        $res = $this->model->create($attr);
        if($res){
            flash('商户新增成功','success');
        }else{
            flash('商户新增成功','error');
        }
	}

    public function updateMerchant(array $attr,$id)
    {
        $attr['expire'] = strtotime($attr['expire']);
        $res = $this->update($attr,$id);
        if ($res){
            flash('商户更新成功','success');
        }else{
            flash('商户更新失败','error');
        }
	}
}
