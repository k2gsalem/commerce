<?php

namespace App\Transformers\Catalogue;

use App\Entities\Catalogue\Item;
use App\Transformers\Assets\AssetTransformer;
use League\Fractal\TransformerAbstract;

class ItemTransfomer extends TransformerAbstract
{
    // protected $defaultIncludes = [
    //     'ItemVariants'
    // ];
    protected $defaultIncludes = [
        'Assets',
    ];
    public function transform(Item $model)
    {
        return [
            'id' => (int) $model->id,
            'item_code'=>(string)$model->item_code,
            'item_desc'=>(string)$model->item_desc,
            'sub_category_id'=>(int)$model->sub_category_id,
            'sub_category_desc'=>(string)$model->subCategory->sub_category_desc,
            'item_image'=>(string)$model->item_image,
            'status_id'=>(int)$model->status_id,
            'status_desc'=>(string)$model->confStatus->status_desc,
            'created_by'=>(int)$model->created_by,
            'vendor_store_id'=>(int)$model->vendor_store_id,
            'vendor'=>(string)$model->store->vendor_name,
            'updated_by'=>(int)$model->updated_by,
            'created_at' => (string)$model->created_at->getTimestamp(),
            'updated_at' => (string)$model->updated_at->getTimestamp(),
          ];
    }
    // public function includeItemVariants(Item $model)
    // {
    //         return $this->collection($model->itemVariant ,new ItemVariantTransformer());
    // }
    public function includeAssets(Item $model)
    {
        return $this->collection($model->assets, new AssetTransformer());
    }

}
