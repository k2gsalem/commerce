<?php

namespace App\Transformers\Catalogue;

use App\Entities\Catalogue\Item;
use App\Transformers\Assets\AssetTransformer;
use League\Fractal\TransformerAbstract;


class ItemTransfomer extends TransformerAbstract
{
    protected $availableIncludes = [
        'ItemVariants','ItemVariantGroups'
    ];
    protected $defaultIncludes = [
        'Assets'
    ];

    protected $supplier_name;

    public function transform(Item $model)
    {
       if($model->supplier_id==Null || (int)$model->supplier_id==0)
       {
     
        $supplier_name = Null;

       }
       else{
             $supplier_name = (string)$model->Supplier->supplier_name;

       }
        
        return [
            'id' => (int) $model->id,
            'item_code'=>(string)$model->item_code,
            'item_desc'=>(string)$model->item_desc,
            'title'=>(string)$model->title,
            'category_id'=>(int)$model->category_id,
            'category_desc'=>(string)$model->Category->category_desc,
            'sub_category_id'=>(int)$model->sub_category_id,
            'sub_category_desc'=>(string)$model->subCategory->sub_category_desc,
            // 'item_image'=>(string)$model->item_image,
            'status_id'=>(int)$model->status_id,
            'status_desc'=>(string)$model->confStatus->status_desc,
            'created_by'=>(int)$model->created_by,
            'min_order_quantity'=> (int) $model->min_order_quantity,
            'min_order_amount'=> sprintf("%.2f",(double) $model->min_order_amount),
            'max_order_quantity'=>(int) $model->max_order_quantity,
            'max_order_amount'=> sprintf("%.2f",(double) $model->max_order_amount),
            'discount_percentage'=>sprintf("%.2f",(double) $model->discount_percentage),
            'discount_amount'=> sprintf("%.2f",(double) $model->discount_amount),
            'quantity'=> (int) $model->quantity,
            'threshold'=> (int) $model->threshold,
            'supplier_id' => (int)$model->supplier_id,
            'supplier_name'=>$supplier_name,
            'vendor_id'=>(int)$model->vendor_id,
            'vendor'=>(string)$model->vendor->vendor_name,
            'vendor_store_id'=>(int)$model->vendor_store_id,
            'vendor_store_name'=>(string)$model->vendorStore->vendor_store_name,
            'MRP'=>sprintf("%.2f",(double)$model->MRP),
            'selling_price'=>sprintf("%.2f",(double)$model->selling_price),
            'has_variants'=>(boolean)$model->has_variants,           
            'updated_by'=>(int)$model->updated_by,
            'created_at' => (string)$model->created_at->getTimestamp(),
            'updated_at' => (string)$model->updated_at->getTimestamp(),
          //  'assets'=>['data'=>$model->itemVariants],
          ];
    }
    public function includeAssets(Item $model)
    {
        return $this->collection($model->assets, new AssetTransformer());
    }
    public function includeItemVariants(Item $model)
    {
        return $this->collection($model->itemVariants, new ItemVariantTransformer());
    }
    public function includeItemVariantGroups(Item $model)
    {
        return $this->collection($model->itemVariantGroups, new ItemVariantGroupTransformer());
    }

}
