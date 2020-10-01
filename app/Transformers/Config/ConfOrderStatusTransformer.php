<?php

namespace App\Transformers\Config;

use App\Entities\Config\ConfOrderStatus;
use League\Fractal\TransformerAbstract;

class ConfOrderStatusTransformer extends TransformerAbstract
{
    public function transform(ConfOrderStatus $model)
    {
        return [
            'id' =>(int)$model->id,
            'status_desc' =>(string)$model->status_desc,
            'created_at' => (string)$model->created_at->getTimestamp(),
            'updated_at' => (string)$model->updated_at->getTimestamp(),
        ];
    }
}
