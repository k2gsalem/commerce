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
            'item_desc'=>(string)$model->item->item_desc,
            'variant_code'=>(string)$model->variant_code,
            'variant_desc'=>(string)$model->variant_desc,
            'variant_image'=>(string)$model->variant_image,
            'status_id'=>(int)$model->status_id,
            'status_desc'=>(string)$model->conStatus->status_desc,
            'created_by'=>(int)$model->created_by,
            'updated_by'=>(int)$model->updated_by,
        ];

    }
}
