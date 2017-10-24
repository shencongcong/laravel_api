<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:38
 */

namespace App\Api\Transformer;

class WaiterLevelTransformer extends  Transformer
{
    public function transformer($items)
    {
        return array_map([$this,'transformerChild'],$items);
    }

    public function transformerChild($item)
    {
        return [
            'id'=>$item['id'],
            'name'=>$item['name'],
        ];
    }

    //单数组数据展示
    public function oneTransformer($item)
    {
        return[
            'id' => $item['id'],
            'name' => $item['name'],
            'merchant_id'=>$item['merchant_id'],
        ];
    }
}