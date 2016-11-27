<?php
/**
 * Created by PhpStorm.
 * User: sudip sarker
 * Date: 11/27/2016
 * Time: 9:38 AM
 */

namespace App\Acme\Transformers;


class TagTransformer extends Transformer
{

    public function transform($tag)
    {
        return [
            'name' => $tag['name']
        ];
    }

}