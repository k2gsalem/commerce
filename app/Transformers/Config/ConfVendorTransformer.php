<?php
namespace App\Transformers\Config;

use App\Entities\Config\ConfVendorCat;
use League\Fractal\TransformerAbstract;

class ConfVendorTransformer extends TransformerAbstract
{
    
    public function transform(ConfVendorCat $model)
    {
        
        return [
            'id' =>(int)$model->id,
            'vendor_cat_desc' =>(string)$model->vendor_cat_desc,
            'status_id'=>(int)$model->status_id, 
            'created_at' => (string)$model->created_at->toIso8601String(),
            'updated_by' => (string)$model->updated_at            
            // 'created_by' => $model->created_by,
            // 'updated_by' => $model->updated_by->toIso8601String(),
            // 'created_at' => $model->created_at->toIso8601String(),
        ];

    }
}
