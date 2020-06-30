<?php
namespace App\Transformers\Config;

use App\Entities\Config\ProdCat;
use League\Fractal\TransformerAbstract;

class ProdCatTransformer extends TransformerAbstract
{
    
    public function transform(ProdCat $model)
    {
        
        return [
            'id' =>(int)$model->id,
            'category_short_code' =>(string)$model->category_short_code,
            'category_desc' =>(string)$model->category_desc,
            'category_image' =>(string)$model->category_image,
            'status_id'=>(int)$model->status_id, 
            'created_at' => (string)$model->created_at->getTimestamp(),
            'updated_by' => (string)$model->updated_at->getTimestamp(),            
            // 'created_by' => $model->created_by,
            // 'updated_by' => $model->updated_by->toIso8601String(),
            // 'created_at' => $model->created_at->toIso8601String(),
        ];

    }
}
