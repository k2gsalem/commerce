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
            'status_desc'=>(string)$model->confStatus->status_desc, 
            'created_at' => (string)$model->created_at->getTimestamp(),
            'updated_at' => (string)$model->updated_at->getTimestamp(),            
            // 'created_by' => $model->created_by,
            // 'updated_by' => $model->updated_by->toIso8601String(),
            // 'created_at' => $model->created_at->toIso8601String(),
        ];

    }
}
