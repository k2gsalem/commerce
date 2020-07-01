<?php

namespace App\Transformers\Catalogue;

use App\Entities\Catalogue\ItemVariant;
use League\Fractal\TransformerAbstract;

class ItemVariantTransformer extends TransformerAbstract
{
    public function transform(ItemVariant $model)
    {
        return [
            'id' => (int) $model->id,
            'item_id'=>(int)$model->item_id,
            'variant_code'=>(string)$model->variant_code,
            'variant_desc'=>(string)$model->variant_desc,
            'variant_image'=>(string)$model->variant_image,
            'status_id'=>(int)$model->status_id,
            'created_by'=>(int)$model->created_by,
            'updated_by'=>(int)$model->updated_by,
        ];

    }
}
