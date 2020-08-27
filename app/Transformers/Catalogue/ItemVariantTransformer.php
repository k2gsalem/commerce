<?php

namespace App\Transformers\Catalogue;

use App\Entities\Catalogue\ItemVariant;
use App\Transformers\Assets\AssetTransformer;
use League\Fractal\TransformerAbstract;
use phpDocumentor\Reflection\Types\Boolean;

class ItemVariantTransformer extends TransformerAbstract
{
   
    protected $defaultIncludes = [
        'Assets',
    ];
    protected $supplier_name;

    public function transform(ItemVariant $model)
    {
       

        $variant_group_desc=null;
     

        if($model->variant_group_id!=null){
            $variant_group_desc=$model->variantGroup->item_group_desc;
        }

        if($model->supplier_id==Null || (int)$model->supplier_id==0)
        {
      
             $supplier_name = Null;
 
        }
        else{
            $supplier_name = (string)$model->Supplier->supplier_name;
 
        }
         
        return [
            'id' => (int) $model->id,
            'item_id'=>(int)$model->item_id,
            'item_desc'=>(string)$model->item->item_desc,
            'variant_code'=>(string)$model->variant_code,
            'variant_desc'=>(string)$model->variant_desc,   
            'variant_group_id'=>$model->variant_group_id,
            'variant_group_desc'=>$variant_group_desc,
            'min_order_quantity'=> (int) $model->min_order_quantity,
            'min_order_amount'=> (float) $model->min_order_amount,
            'max_order_quantity'=>(int) $model->max_order_quantity,
            'max_order_amount'=> (float) $model->max_order_amount,
            'discount_percentage'=> (float) $model->discount_percentage,
            'discount_amount'=> (float) $model->discount_amount,
            'quantity'=>(int) $model->quantity,
            'threshold'=> (float) $model->threshold,
            'supplier_id' => (int)$model->supplier_id,
            'supplier_name'=>$supplier_name,
            'vendor_id'=>(int)$model->vendor_id,
            'vendor'=>(string)$model->vendor->vendor_name,
            'vendor_store_id'=>(int)$model->vendor_store_id,
            'vendor_store_name'=>(string)$model->vendorStore->vendor_store_name,
            'MRP'=>(float)$model->MRP,
            'selling_price'=>(float)$model->selling_price,
            'default'=>(boolean)$model->default,           
            'status_id'=>(int)$model->status_id,
            'status_desc'=>(string)$model->conStatus->status_desc,
            'created_at' => (string)$model->created_at->getTimestamp(),
            'updated_at' => (string)$model->updated_at->getTimestamp(),
        ];

    }
    public function includeAssets(ItemVariant $model)
    {
        return $this->collection($model->assets, new AssetTransformer());
    }
}
