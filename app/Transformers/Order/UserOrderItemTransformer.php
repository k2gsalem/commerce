<?php

namespace App\Transformers\Order;

use App\Entities\Order\UserOrderItem;
use League\Fractal\TransformerAbstract;

class UserOrderItemTransformer extends TransformerAbstract
{
    public function transform(UserOrderItem $model)
    {
        return [
            'id' =>(int)$model->id,           
            'created_at' => (string)$model->created_at->getTimestamp(),
            'updated_at' => (string)$model->updated_at->getTimestamp(),
        ];
    }
}
