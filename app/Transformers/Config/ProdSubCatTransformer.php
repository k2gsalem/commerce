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
            'category_id'=>(int)$model->category_id,
            'category_desc'=>$model->category->category_desc,
            'sub_category_short_code' =>(string)$model->sub_category_short_code,
            'sub_category_desc' =>(string)$model->sub_category_desc,
            'sub_category_image' =>(string)$model->sub_category_image,
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
