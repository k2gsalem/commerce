<?php

namespace App\Transformers\Stock;

use App\Entities\Stock\StockMaster;
use League\Fractal\TransformerAbstract;


class StockMasterTransformer extends TransformerAbstract
{
    //  protected $defaultIncludes = [
    //     'ItemVariants'
    // ];
    public function transform(StockMaster $model)
    {
        return [
            'id' => (int) $model->id,
            'item_id'=>(int)$model->item_id,
            'item_desc'=>(string)$model->item->item_desc,
            'variant_id' => (int)$model->variant_id,
            'variant_desc' => (string)$model->variant->variant_desc,
            'vendor_id' => (int)$model->vendor_id,
            'vendor_name' => (string)$model->vendor->vendor_name,
            'stock_quantity' => (float)$model->stock_quantity,
            'stock_threshold' => (float)$model->stock_threshold,
            'status_id' => (int)$model->status_id,
            'status_desc' => (string)$model->confStatus->status_desc,
            'created_at' => (string)$model->created_at->getTimestamp(),
            'updated_at' => (string)$model->updated_at->getTimestamp(),

        ];
    }
    // public function includeItemVariants(StockMaster $model)
    // {
    //         return $this->collection($model->variant ,new ItemVariantTransformer());
    // }

}
