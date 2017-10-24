<?php

namespace App\Api\Transformer;

/**
 * Class Transform
 * @package App\Transform
 */
abstract class Transformer
{
    /**
     * @param $items
     * @return array
     */
    public function transformer($items)
    {
        return array_map([$this,'transformChild'],$items);
    }
    /**
     * @param $item
     * @return mixed
     */
    abstract public function transformerChild($item);
}