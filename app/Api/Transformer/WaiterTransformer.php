<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:38
 */

namespace App\Api\Transformer;

class WaiterTransformer extends  Transformer
{
    public function transformer($items)
    {
        return array_map([$this,'transformerChild'],$items);
    }

    public function transformerChild($item)
    {
        return [
            'id'=>$item['id'],
            'nickname'=>$item['nickname'],
            'sex'=>$item['sex'],
            'brief'=>$item['brief'],
            'level'=>$item['level'],
            'tel'=>$item['tel'],
            'img'=>$item['img'],
            'work_length'=>$item['work_length']
        ];
    }

    //单数组数据显示
    public function oneTransformer($item)
    {
        return [
            'id'=>$item['id'],
            'nickname'=>$item['nickname'],
            'sex'=>$item['sex'],
            'brief'=>$item['brief'],
            'level'=>$item['level'],
            'tel'=>$item['tel'],
            'img'=>$item['img'],
            'work_length'=>$item['work_length']
        ];
    }

    /*
     * 服务师端
     * */
    //服务师首页
    public function indexTransformer($item)
    {
        return [
            'nickname'=>$item['nickname'],
            'img'=>$item['img'],
        ];
    }
    //服务师编辑信息展示
    public function editTransformer($item)
    {
        return [
            'id'=>$item['id'],
            'nickname'=>$item['nickname'],
            'sex'=>$item['sex'],
            'brief'=>$item['brief'],
            'level'=>$item['level'],
            'tel'=>$item['tel'],
            'img'=>$item['img'],
            'work_length'=>$item['work_length'],
            'shop_id' =>$item['shop_id'],
             'goods_id' =>$item['goods_id']
        ];
    }
    
    /*
     * 客户端 
     * */
    //服务师详情展示
    public function waiterShowTransformer($item)
    {
        return [
            'id'=>$item['id'],
            'nickname'=>$item['nickname'],
            'brief'=>$item['brief'],
            'level_name'=>$item['level_name'],
            'img'=>$item['img'],
            'work_length'=>$item['work_length'],
            'album_num' =>$item['album_num'],
            'appoint_num' =>$item['appoint_num'],
            'waiter_grade' =>$item['waiter_grade'],
            'comment' =>$item['comment'],
        ];
    }
}