<?php

namespace App\Transformers\Order;

use App\Entities\Order\UserOrder;
use League\Fractal\TransformerAbstract;

class UserOrderTransformer extends TransformerAbstract
{
    public function transform(UserOrder $model)
    {
        return [
            'id' =>(int)$model->id,           
            'created_at' => (string)$model->created_at->getTimestamp(),
            'updated_at' => (string)$model->updated_at->getTimestamp(),
        ];
    }
}
