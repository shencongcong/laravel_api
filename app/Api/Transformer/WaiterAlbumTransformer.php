<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:38
 */

namespace App\Api\Transformer;


class WaiterAlbumTransformer extends Transformer
{
    public function transformer($items)
    {
        return array_map([$this, 'transformerChild'], $items);
    }

    public function transformerChild($item)
    {
        return [
            'id' => $item['id'],
            'name' => $item['name'],
            'introduce' => $item['introduce'],
            'img' => $item['img'],
            'waiter_name' => $item['waiter_name'],
            'shop_name' => $item['shop_name'],
            'created_time' => $item['created_time']
        ];
    }

    //单数组展示
    public function oneTransformer($item)
    {
        return [
            'id' => $item['id'],
            'name' => $item['name'],
            'waiter_img'=>$item['waiter_img'],
            'introduce' => $item['introduce'],
            'img' => $item['img'],
            'waiter_name' => $item['waiter_name'],
            'shop_name' => $item['shop_name'],
            'level_name' => $item['level_name'],
            'time' => $item['time']
        ];
    }
}