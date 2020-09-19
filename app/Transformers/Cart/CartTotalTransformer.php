<?php

namespace App\Transformers\Cart;

use App\Entities\CartManager\Cart;
use League\Fractal\TransformerAbstract;

class CartTotalTransformer extends TransformerAbstract
{
    protected $sub_total;
    public function transform(Cart $model)
    {
        $sub_total=0;
        $items = $model->cartItem;
        foreach ($items as $item) {
            $sub_total += $item->item_selling_price * $item->item_quantity;
        }
        $total_quantity = $model->cartItem->sum('item_quantity');
        return [
            'cart_id' => (int)$model->id,
            'user_id' => (int)$model->user_id,
            'sub_total' => (float)$sub_total,
            'tax'=>0,
            'total_quantity'=>(int)$total_quantity,
            'payable'=>(float)$sub_total,
        ];
    }
}
