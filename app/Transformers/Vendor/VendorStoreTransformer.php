<?php
namespace App\Transformers\Vendor;

use App\Entities\Vendor\VendorStore;
use App\Transformers\Assets\AssetTransformer;
use League\Fractal\TransformerAbstract;

class VendorStoreTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'Assets',
    ];

    public function transform(VendorStore $model)
    {

        return [
            'id' => (int) $model->id,
            'vendor_id' => (string) $model->vendor_id,
            'vendor_name' => (string) $model->Vendor->vendor_name,
            // 'vendor_logo' => (string) $model->vendor_logo,
            'vendor_store_name' => (string) $model->vendor_store_name,
            'vendor_store_location' => (string) $model->vendor_store_location,
            'vendor_store_address' => (string) $model->vendor_store_address,
            'vendor_store_contact' => (string) $model->vendor_store_contact,
            'latitude' => (string) $model->latitude,
            'longitude' => (string) $model->longitude,
            'status_id' => (int) $model->status_id,
            'status_desc' => (string) $model->confStatus->status_desc,
            'created_at' => (string) $model->created_at->getTimestamp(),
            'updated_at' => (string) $model->updated_at->getTimestamp(),
            // 'created_by' => $model->created_by,
            // 'updated_by' => $model->updated_by->toIso8601String(),
            // 'created_at' => $model->created_at->toIso8601String(),
        ];

    }
    public function includeAssets(VendorStore $model)
    {
        return $this->collection($model->assets, new AssetTransformer());
    }
}
