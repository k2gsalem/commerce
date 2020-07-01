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
            'status_desc'=>(string)$model->confStatus->status_desc, 
            'created_at' => (string)$model->created_at->getTimestamp(),
            'updated_at' => (string)$model->updated_at->getTimestamp(),            
            // 'created_by' => $model->created_by,
            // 'updated_by' => $model->updated_by->toIso8601String(),
            // 'created_at' => $model->created_at->toIso8601String(),
        ];

    }
}
