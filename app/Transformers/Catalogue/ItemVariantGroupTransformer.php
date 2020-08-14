<?php
namespace App\Transformers\Catalogue;

use App\Entities\Catalogue\ItemVariantGroup;
use League\Fractal\TransformerAbstract;
use phpDocumentor\Reflection\Types\Boolean;

class ItemVariantGroupTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'ItemVariants',
    ];
    public function transform(ItemVariantGroup $model)
    {
        return [
            'id' => (int) $model->id,
            'item_id' => (int) $model->item_id,
            'item_desc' => (string) $model->item->item_desc,
            'item_group_desc' => (string) $model->item_group_desc,
            'default'=>(boolean)$model->default,
            'status_id' => (int) $model->status_id,
            'status_desc' => (string) $model->conStatus->status_desc,
            'created_at' => (string) $model->created_at->getTimestamp(),
            'updated_at' => (string) $model->updated_at->getTimestamp(),
        ];

    }
    public function includeItemVariants(ItemVariantGroup $model)
    {
        return $this->collection($model->itemVariants, new ItemVariantTransformer());
    }
}
