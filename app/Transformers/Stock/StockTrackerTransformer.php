<?php

namespace App\Transformers\Stock;

use App\Entities\Stock\StockTracker;
use League\Fractal\TransformerAbstract;

class StockTrackerTransformer extends TransformerAbstract
{
    public function transform(StockTracker $model)
    {
        return [
            'id' => (int) $model->id,
            'item_id'=>(int)$model->item_id,
            'item_desc'=>(string)$model->item->item_desc,
            'variant_id' => (int)$model->variant_id,
            'variant_desc' => (string)$model->variant->variant_desc,
            'supplier_id' => (int)$model->supplier_id,
            'supplier_name'=>(string)$model->supplier->supplier_name,
            'purchase_order_ref'=>(string)$model->purchase_order_ref,
            'purchase_order_date'=>(string)$model->purchase_order_date,
            'purchase_price'=>(float)$model->purchase_price,
            'stock_quantity' => (float)$model->stock_quantity,
            'comments'=>(string)$model->comments,                      
            'status_id' => (int)$model->status_id,
            'status_desc' => (string)$model->confStatus->status_desc,
            'created_at' => (string)$model->created_at->getTimestamp(),
            'updated_at' => (string)$model->updated_at->getTimestamp(),

        ];
    }
}
