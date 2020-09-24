<?php

namespace App\Transformers\Cart;

use App\Entities\CartManager\CartItem;
use App\Entities\Catalogue\Item;
use App\Transformers\Assets\AssetTransformer;
use League\Fractal\TransformerAbstract;

class CartItemTransformer extends TransformerAbstract
{
    // protected $defaultIncludes = [
    //     'CartItemVariants'
    // ];
    protected $defaultIncludes = [
        'Assets',
    ];
    public function transform(CartItem $model)
    {
        $item = new Item();
        $item_model = $item->find($model->item_id);

        return [
            'cart_id' => (int) $model->cart_id,
            'item_id' => (int) $model->item_id,
            'item_desc' => (string) $item_model->item_desc,
            'variant_group_id' => (int) $model->variant_group_id,
            'item_selling_price' => (int) $model->item_selling_price,
            'item_discount_percentage' => (int) $model->item_discount_percentage,
            'item_discount_amount' => (int) $model->item_discount_amount,
            'item_quantity' => (int) $model->item_quantity,
            'vendor_store_id' => (int) $model->vendor_store_id,
            // 'status_id' => (int) $model->status_id,
            'created_by' => (int) $model->created_by,
            'updated_by' => (int) $model->updated_by,
            'created_at' => (string) $model->created_at,
            'updated_at' => (string) $model->updated_at,
        ];

    }
    public function includeAssets(CartItem $model)
    {
        $item = new Item();
        $item_model = $item->find($model->item_id);

        return $this->collection($item_model->assets, new AssetTransformer());
    }
}
