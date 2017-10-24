<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:38
 */

namespace App\Api\Transformer;

class GoodsCateTransformer extends  Transformer
{
    public function transformer($items)
    {
        return array_map([$this,'transformerChild'],$items);
    }

    public function transformerChild($item)
    {
        return [
            'id'=>$item['id'],
            'goods_name'=>$item['goods_name'],
            'price'=>$item['price'],
        ];
    }
}