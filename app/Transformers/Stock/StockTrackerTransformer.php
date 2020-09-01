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
            'vendor_id'=>(int)$model->vendor_id,
            'vendor'=>(string)$model->vendor->vendor_name,
            'vendor_store_id'=>(int)$model->vendor_store_id,
            'vendor_store_name'=>(string)$model->vendorStore->vendor_store_name,
            'order_ref'=>(string)$model->order_ref,
            'order_date'=>(string)$model->order_date,
            'order_type_id'=>(int)$model->order_type_id,
            'order_type_desc'=>(string)$model->confOrderType->order_type_desc,
            'MRP'=>(float)$model->MRP,
            'purchase_price'=>(float)$model->purchase_price,
            'selling_price'=>(float)$model->selling_price,
            'stock_quantity' => (float)$model->stock_quantity,
            'total_amount'=>(float)$model->total_amount,
            'payment_status_id' => (int)$model->payment_status_id,
            'payment_status_desc' => (string)$model->confPaymentStatus->payment_status_desc,
            'payment_date'=>(string)$model->payment_date,
            'comments'=>(string)$model->comments,                      
            'status_id' => (int)$model->status_id,
            'status_desc' => (string)$model->confStatus->status_desc,
            'created_at' => (string)$model->created_at->getTimestamp(),
            'updated_at' => (string)$model->updated_at->getTimestamp(),

        ];
    }
}
