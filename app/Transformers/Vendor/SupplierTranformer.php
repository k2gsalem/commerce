<?php
namespace App\Transformers\Vendor;

use App\Entities\Vendor\Supplier;
use App\Transformers\Assets\AssetTransformer;
use App\Transformers\Config\ConfSupplierTransformer;
use League\Fractal\TransformerAbstract;

class SupplierTransformer extends TransformerAbstract
{
    // protected $defaultIncludes = ['consupplier'];
    protected $defaultIncludes = [
        'Assets',
    ];
    public function transform(Supplier $model)
    {
        

        return [
            'id' => (int) $model->id,
            'supplier_name' => (string) $model->supplier_name,
            // 'supplier_logo' => (string) $model->supplier_logo,
            'supplier_category_id' => (int) $model->supplier_category_id,
            'supplier_category_desc' => $model->supplierCategory->supplier_cat_desc,
            'supplier_desc' => (string) $model->supplier_desc,
            'supplier_address' => (string) $model->supplier_address,     
            'supplier_contact' => (string) $model->supplier_contact,
            'supplier_email' => (string) $model->supplier_email,
            'status_id' => (int) $model->status_id,
            'status_desc' => (string) $model->confStatus->status_desc,
            'created_at' => (string) $model->created_at->getTimestamp(),
            'updated_at' => (string) $model->updated_at->getTimestamp(),
          
        ];

    }
    // public function includeConfSupplier(Supplier $model)
    // {
    //     return $this->item($model->supplierCategory, new ConfSupplierTransformer()); 
    //    // return $this->collection($model->confStatus, new ConfStatusTransformer());
    // }
    public function includeAssets(Supplier $model)
    {
        
        return $this->collection($model->assets, new AssetTransformer());
    }
}
