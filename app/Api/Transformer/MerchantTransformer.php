<?php

namespace App\Api\Transformer;

class MerchantTransformer extends Transformer
{


    public function transformer($items)
    {
        return array_map([$this,'transformerChild'],$items);
    }

    public function transformerChild($item)
    {
        return [
            'merchant_name' => $item['merchant_name'],
            'shop_nums' => $item['shop_nums'],
            'logo' => $item['logo'],
        ];
    }
}