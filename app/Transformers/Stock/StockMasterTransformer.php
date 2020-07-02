<?php

namespace App\Transformers\Stock;

use App\Entities\Stock\StockMaster;
use League\Fractal\TransformerAbstract;
use PhpParser\Node\Expr\Cast\Double;

class StockMasterTransformer extends TransformerAbstract
{
    public function transform(StockMaster $model)
    {
        return [
            'id' => (int) $model->id,
            'variant_id'=>(int)$model->variant_id,
            'variant_desc'=>(string)$model->variant->variant_desc,
            'vendor_id'=>(int)$model->vendor_id,
            'vendor_name'=>(string)$model->vendor->vendor_name,
            'stock_quantity'=>(float)$model->stock_quantity,
            'stock_threshold'=>(float)$model->stock_threshold,
            'status_id'=>(int)$model->status_id,
            'status_desc'=>(string)$model->confStatus->status_desc,
            'created_by'=>(int)$model->created_by,
            'updated_by'=>(int)$model->updated_by,
           
        ];
    }
}
