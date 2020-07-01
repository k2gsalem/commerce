<?php

namespace App\Transformers\Catalogue;

use App\Entities\Catalogue\Item;
use League\Fractal\TransformerAbstract;

class ItemTransfomer extends TransformerAbstract
{
    public function transform(Item $model)
    {
        return [
            'id' => (int) $model->id,
            'item_code'=>(string)$model->item_code,
            'item_desc'=>(string)$model->item_desc,
            'sub_category_id'=>(int)$model->sub_category_id,
            'item_image'=>(string)$model->item_image,
            'status_id'=>(int)$model->status_id,
            'created_by'=>(int)$model->created_by,
            'vendor_store_id'=>(int)$model->vendor_store_id,
            'updated_by'=>(int)$model->updated_by,
            'created_at' => (string)$model->created_at->getTimestamp(),
            'updated_at' => (string)$model->updated_at->getTimestamp(),
          ];
    }

}
