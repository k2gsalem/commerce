<?php

namespace App\Transformers\Cart;

use App\Entities\CartManager\Cart;
use League\Fractal\TransformerAbstract;

class CartTransformer extends TransformerAbstract
{
    // protected $availableIncludes = [
    //     'ItemVariants','ItemVariantGroups'
    // ];
    protected $defaultIncludes = [
        'CartItem',
         'Total'
    ];
    public function transform(Cart $model)
    {
        return[
            'id' => (int) $model->id,
            'user_id'=>(int)$model->user_id,
            'status_id'=>(int)$model->status_id,
            'created_by'=>(int)$model->created_by,
            'updated_by'=>(int)$model->updated_by,
            'created_at'=>(string)$model->created_at,
            'updated_at'=>(string)$model->updated_at,
        ];

    }
    public function includeCartItem(Cart $model)
    {
        return $this->collection($model->cartItem, new CartItemTransformer());
    }
    public function includeTotal(Cart $model)
    {
        return $this->item($model, new CartTotalTransformer() );
        //return $this->item($model->cartItem, new CartItemTransformer());
    }
   
  

}
