<?php

namespace App\Transformers\Config;

use App\Entities\Config\ProdCat;
use App\Transformers\Assets\AssetTransformer;
use League\Fractal\TransformerAbstract;

class ProdCatTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'SubCategories'
    ];
    protected $defaultIncludes = [
       'Assets'
    ];
    public function transform(ProdCat $model)
    {

        return [
            'id' => (int) $model->id,
            'category_short_code' => (string) $model->category_short_code,
            'category_desc' => (string) $model->category_desc,
            'title'=>(string)$model->title,
            //  'category_image' => (string) $model->assets->thumb,
            'status_id' => (int) $model->status_id,
            'status_desc' => (string) $model->confStatus->status_desc,
            'created_at' => (string) $model->created_at->getTimestamp(),
            'updated_at' => (string) $model->updated_at->getTimestamp(),

        ];
    }

    public function includeAssets(ProdCat $model)
    {
        return $this->collection($model->assets, new AssetTransformer());
    }
    public function includeSubCategories(ProdCat $model)
    {
        return $this->collection($model->subCategories, new ProdSubCatTransformer());
    }
}
