<?php
namespace App\Transformers\Config;

use App\Entities\Config\ConfOrderType;
use League\Fractal\TransformerAbstract;

class ConfOrderTypeTransformer extends TransformerAbstract
{
    
    public function transform(ConfOrderType $model)
    {
        
        return [
            'id' =>(int)$model->id,
            'order_type_desc' =>(string)$model->order_type_desc,
            'title'=>(string)$model->title,
            'created_at' => (string)$model->created_at->getTimestamp(),
            'updated_at' => (string)$model->updated_at->getTimestamp(),            
            // 'created_by' => $model->created_by,
            // 'updated_by' => $model->updated_by->toIso8601String(),
            // 'created_at' => $model->created_at->toIso8601String(),
        ];

    }
}
