<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:38
 */

namespace App\Api\Transformer;


use App\models\Shop;

/**
 * Class ShopTransformer
 * @package App\Api\Transformer
 */
class ShopTransformer extends Transformer
{
    public function transformer($items)
    {
        return array_map([$this, 'transformerChild'], $items);
    }

    public function transformerChild($item)
    {
        return [
            'id' => $item['id'],
            'img0' => $item['img0'],
            'shop_name' => $item['shop_name'],
            'tel' => $item['tel'],
            'address' => $item['address'] . $item['detail_address']
        ];
    }


    /**
     * 一维数组
     * @param $item
     * @return array
     */
    public function oneTransformer($item)
    {
        return [
            'id' => $item['id'],
            'shop_name' => $item['shop_name'],
            'tel' => $item['tel'],
            'address' => $item['address'],
            'detail_address' => $item['detail_address'],
            'open_time' => $item['open_time'],
            'introduce' => $item['introduce'],
            'longitude' => $item['longitude'],
            'latitude' => $item['latitude'],
            'img0' => $item['img0'],
            'img1' => $item['img1'],
            'img2' => $item['img2'],
            'img3' => $item['img3'],
        ];
    }


    /*
     * 客户端店铺首页信息展示
     * @param $item
     * @return array
     * */
    public function memberTransformer($item)
    {
        return [
            'id' => $item['id'],
            'shop_name' => $item['shop_name'],
            'address' => $item['address'],
            'introduce' => $item['address'],
            'img' => $item['img'],
            'juli' => $item['juli']
        ];
    }


    /**
     * 客户端门店详细信息展示
     * @param $item
     * @return array
     */
    public function memberShopShowTransformer($item)
    {
        return [
            'id' => $item['id'],
            'shop_name' => $item['shop_name'],
            'address' => $item['address'],
            'introduce' => $item['address'],
            'img' => $item['img'],
            'juli' => $item['juli'],
            'open_time' => $item['open_time'],
            'appoint_num' => $item['appoint_num'],
            'tel' => $item['tel'],
        ];
    }

    //客户端 门店列表
    public function memberShopListTransformer($items)
    {
        return array_map([$this, 'memberShopListTransformerChild'], $items);
    }
    //客户端 门店列表
    public function memberShopListTransformerChild($item)
    {
        return [
            'id' => $item['id'],
            'img0' => $item['img'][0],
            'shop_name' => $item['shop_name'],
            'address' => $item['address'] . $item['detail_address'],
            'juli' => $item['juli'],
            'open_time'=>$item['open_time'],
            'merchant_id'=>$item['merchant_id']
        ];
    }

}