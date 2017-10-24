<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:38
 */

namespace App\Api\Transformer;

class AppointTransformer extends Transformer
{
    public function transformer($items)
    {
        return array_map([$this, 'transformerChild'], $items);
    }

    public function transformerChild($item)
    {
        return [
            'member_name' => $item['member_name'],
            'member_img' => $item['member_img'],
            'shop_name' => $item['shop_name'],
            'waiter_name' => $item['waiter_name'],
            'good_cate' => $item['good_cate'],
            'time_date' => $item['time_date'],
            'time_hour' => $item['time_hour']
        ];
    }

    //服务师端
    public function waiterTransformer($items)
    {
        return array_map([$this, 'waiterTransformerChild'], $items);
    }
    //服务师端
    public function waiterTransformerChild($item)
    {
        return [
            'id' => $item['id'],
            'tel' => $item['tel'],
            'member_name' => $item['member_name'],
            'member_img' => $item['member_img'],
            'shop_name' => $item['shop_name'],
            'waiter_name' => $item['waiter_name'],
            'good_cate' => $item['good_cate'],
            'time_date' => $item['time_date'],
            'time_hour' => $item['time_hour'],
            'remark' =>$item['remark']
        ];
    }

    //客户端
    public function memberTransformer($items)
    {
        return array_map([$this, 'memberTransformerChild'], $items);
    }
    //客户端
    public function memberTransformerChild($item)
    {
        return [
            'id' => $item['id'],
            'waiter_name' => $item['waiter_name'],
            'waiter_img' => $item['waiter_img'],
            'waiter_tel' =>$item['waiter_tel'],
            'shop_name' => $item['shop_name'],
            'goods_name' => $item['goods_name'],
            'goods_price' =>$item['goods_price'],
            'time_date' => $item['time_date'],
            'time_hour' => $item['time_hour'],
            'remark' =>$item['remark'],


        ];
    }

    //客户端  已完成的预约
    public function memberCompletedTransformer($items)
    {
        return array_map([$this, 'memberCompletedTransformerChild'], $items);
    }
    //客户端
    public function memberCompletedTransformerChild($item)
    {
        return [
            'id' => $item['id'],
            'waiter_name' => $item['waiter_name'],
            'waiter_img' => $item['waiter_img'],
            'waiter_tel' =>$item['waiter_tel'],
            'shop_name' => $item['shop_name'],
            'goods_name' => $item['goods_name'],
            'goods_price' =>$item['goods_price'],
            'time_date' => $item['time_date'],
            'time_hour' => $item['time_hour'],
            'remark' =>$item['remark'],
            'comment'=>$item['comment'],
            'is_comment'=>$item['is_comment'],

        ];
    }

}