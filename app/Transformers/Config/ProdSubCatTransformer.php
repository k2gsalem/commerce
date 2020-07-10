<?php
namespace App\Transformers\Config;

use App\Entities\Config\ProdSubCat;
use App\Transformers\Assets\AssetTransformer;
use App\Transformers\Catalogue\ItemTransfomer;
use League\Fractal\TransformerAbstract;

class ProdSubCatTransformer extends TransformerAbstract
{
    // protected $defaultIncludes = [
    //     'Items'
    // ];
    protected $defaultIncludes = [
        'Assets',
    ];
    
    public function transform(ProdSubCat $model)
    {
        
        return [
            'id' =>(int)$model->id,
            'category_id'=>(int)$model->category_id,
            'category_desc'=>$model->category->category_desc,
            'sub_category_short_code' =>(string)$model->sub_category_short_code,
            'sub_category_desc' =>(string)$model->sub_category_desc,
            'sub_category_image' =>(string)$model->sub_category_image,
            'status_id'=>(int)$model->status_id,
            'status_desc'=>(string)$model->confStatus->status_desc, 
            'created_at' => (string)$model->created_at->getTimestamp(),
            'updated_at' => (string)$model->updated_at->getTimestamp(),            
           
        ];

    }
    // public function includeItems(ProdSubCat $model)
    // {
    //         return $this->collection($model->item ,new ItemTransfomer());
    // }
    public function includeAssets(ProdSubCat $model)
    {
        return $this->collection($model->assets, new AssetTransformer());
    }
}
