<?php
namespace App\Transformers\Config;

use App\Entities\Config\ConfStatus;
use App\Entities\Config\ConfSupplierCat;
use League\Fractal\TransformerAbstract;

class ConfSupplierTransformer extends TransformerAbstract
{
    //  protected $defaultIncludes = ['confStatus'];

    public function transform(ConfSupplierCat $model)
    {
        
        return [
            'id' =>(int)$model->id,
            'supplier_cat_desc' =>(string)$model->supplier_cat_desc,
            'status_id'=>(int)$model->status_id, 
            'status_desc'=>(string)$model->confStatus->status_desc,
            'created_at' => (string)$model->created_at->getTimestamp(),
            'updated_at' => (string)$model->updated_at->getTimestamp(),            
            
        ];

    }
    // public function includeConfStatus(ConfSupplierCat $model)
    // {
    //     return $this->item($model->confStatus, new ConfStatusTransformer()); 
    //    // return $this->collection($model->confStatus, new ConfStatusTransformer());
    // }
}
