<?php
namespace App\Transformers\Config;

use App\Entities\Config\ProdSubCat;
use League\Fractal\TransformerAbstract;

class ProdSubCatTransformer extends TransformerAbstract
{
    
    public function transform(ProdSubCat $model)
    {
        
        return [
            'id' =>(int)$model->id,
            'sub_category_short_code' =>(string)$model->sub_category_short_code,
            'sub_category_desc' =>(string)$model->sub_category_desc,
            'sub_category_image' =>(string)$model->sub_category_image,
            'status_id'=>(int)$model->status_id, 
            'created_at' => (string)$model->created_at->getTimestamp(),
            'updated_by' => (string)$model->updated_at->getTimestamp(),            
            // 'created_by' => $model->created_by,
            // 'updated_by' => $model->updated_by->toIso8601String(),
            // 'created_at' => $model->created_at->toIso8601String(),
        ];

    }
}
