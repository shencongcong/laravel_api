<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:38
 */

namespace App\Api\Transformer;

class AppointRankTransformer extends  Transformer
{
    public function transformer($items)
    {
        return array_map([$this,'transformerChild'],$items);
    }

    public function transformerChild($item)
    {
        return [
            'id'=>$item['id'],
            'shop_logo'=>$item['shop_logo'],
            'shop_name'=>$item['shop_name'],
            'tel'=>$item['tel'],
            'address'=>$item['address']
        ];
    }
}