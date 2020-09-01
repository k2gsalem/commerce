<?php
namespace App\Transformers\Config;

use App\Entities\Config\ConfPaymentStatus;
use League\Fractal\TransformerAbstract;

class ConfPaymentStatusTransformer extends TransformerAbstract
{
    
    public function transform(ConfPaymentStatus $model)
    {
        
        return [
            'id' =>(int)$model->id,
            'payment_status_desc' =>(string)$model->payment_status_desc,
            'title'=>(string)$model->title,
            'created_at' => (string)$model->created_at->getTimestamp(),
            'updated_at' => (string)$model->updated_at->getTimestamp(),            
            // 'created_by' => $model->created_by,
            // 'updated_by' => $model->updated_by->toIso8601String(),
            // 'created_at' => $model->created_at->toIso8601String(),
        ];

    }
}
