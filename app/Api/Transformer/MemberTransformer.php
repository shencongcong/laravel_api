<?php
/**
 * Created by PhpStorm.
 * User: muyi
 * Date: 2017/8/7
 * Time: 13:38
 */

namespace App\Api\Transformer;

class MemberTransformer extends Transformer
{
    public function transformer($items)
    {
        return array_map([$this, 'transformerChild'], $items);
    }

    public function transformerChild($item)
    {
        return [
            'id' => $item['id'],
            'nickname' => $item['nickname'],
            'sex' => $item['sex'],
            'brief' => $item['brief'],
            'level' => $item['level'],
            'tel' => $item['tel'],
            'img' => $item['img'],
            'work_length' => $item['work_length']
        ];
    }

    //单数组数据显示
    public function oneTransformer($item)
    {
        return [
            'id' => $item['id'],
            'nickname' => $item['nickname'],
            'sex' => $item['sex'],
            'brief' => $item['brief'],
            'level' => $item['level'],
            'tel' => $item['tel'],
            'img' => $item['img'],
            'work_length' => $item['work_length']
        ];
    }
    //首页信息展示
    public function indexTransformer($item)
    {
        return [
            'member_name' => $item['member_name'],
            'img' => $item['img'],
            'tel' => $item['tel'],
        ];
    }
    //首页信息编辑展示
    public function editTransformer($item)
    {
        return [
            'member_name' => $item['member_name'],
            'img' => $item['img'],
            'tel' => $item['tel'],
            'sex' => $item['sex']
        ];
    }

    /*
     * 商户端 会员列表
     * */
    public function merchantTransformer($items)
    {
        return array_map([$this, 'merchantTransformerChild'], $items);
    }

    public function merchantTransformerChild($item)
    {
        return [
            'id' => $item['id'],
            'member_name' => $item['member_name'],
            'tel' => $item['tel'],
            'img' => $item['img'],
            'created_at'=>date('Y-m-d ',$item['created_at'])
        ];
    }
}