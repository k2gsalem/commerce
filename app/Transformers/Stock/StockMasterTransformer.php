<?php

namespace App\Transformers\Stock;

use App\Entities\Stock\StockMaster;
use League\Fractal\TransformerAbstract;

class StockMasterTransformer extends TransformerAbstract
{
    public function transform(StockMaster $model)
    {
        return [
            'id' => (int) $model->id,
            'variant_id'=>(int)$model->variant_id,
            'vendor_id'=>(int)$model->vendor_id,
            'stock_quantity'=>(int)$model->stock_quantity,
            'stock_threshold'=>(int)$model->stock_threshold,
            'status_id'=>(int)$model->status_id,
            'created_by'=>(int)$model->created_by,
            'updated_by'=>(int)$model->updated_by,
           
        ];
    }
}
