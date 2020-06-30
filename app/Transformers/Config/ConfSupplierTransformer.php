<?php
namespace App\Transformers\Config;

use App\Entities\Config\ConfSupplierCat;
use League\Fractal\TransformerAbstract;

class ConfSupplierTransformer extends TransformerAbstract
{
    
    public function transform(ConfSupplierCat $model)
    {
        
        return [
            'id' =>(int)$model->id,
            'supplier_cat_desc' =>(string)$model->supplier_cat_desc,
            'status_id'=>(int)$model->status_id, 
            'created_at' => (string)$model->created_at->getTimestamp(),
            'updated_by' => (string)$model->updated_at->getTimestamp(),            
            // 'created_by' => $model->created_by,
            // 'updated_by' => $model->updated_by->toIso8601String(),
            // 'created_at' => $model->created_at->toIso8601String(),
        ];

    }
}
