<?php

namespace App\Transformers\Catalogue;

use App\Entities\Catalogue\ItemVariant;
use App\Transformers\Assets\AssetTransformer;
use League\Fractal\TransformerAbstract;

class ItemVariantTransformer extends TransformerAbstract
{
   
    protected $defaultIncludes = [
        'Assets',
    ];
    public function transform(ItemVariant $model)
    {
        $variant_group_desc=null;
        if($model->variant_group_id!=null){
            $variant_group_desc=$model->variantGroup->item_group_desc;
        }
        return [
            'id' => (int) $model->id,
            'item_id'=>(int)$model->item_id,
            'item_desc'=>(string)$model->item->item_desc,
            'variant_code'=>(string)$model->variant_code,
            'variant_desc'=>(string)$model->variant_desc,   
            'variant_group_id'=>$model->variant_group_id,
            'variant_group_desc'=>$variant_group_desc,
            // 'variant_image'=>(string)$model->variant_image,
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
