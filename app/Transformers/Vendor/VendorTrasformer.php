<?php
namespace App\Transformers\Vendor;

use App\Entities\Vendor\Vendor;
use League\Fractal\TransformerAbstract;

class VendorTransformer extends TransformerAbstract
{

    public function transform(Vendor $model)
    {

        return [
            'id' => (int) $model->id,
            'vendor_name' => (string) $model->vendor_name,
            'vendor_logo' => (string) $model->vendor_logo,
            'vendor_category_id' => (int) $model->vendor_category_id,
            'vendor_category_desc' => (string) $model->vendorCategory->vendor_cat_desc,
            'vendor_desc' => (string) $model->vendor_desc,
            'vendor_address' => (string) $model->vendor_address,
            'vendor_contact' => (string) $model->vendor_contact,
            'vendor_email' => (string) $model->vendor_email,
            'status_id' => (int) $model->status_id,
            'status_desc' => (string) $model->confStatus->status_desc,
            'created_at' => (string) $model->created_at->getTimestamp(),
            'updated_at' => (string) $model->updated_at->getTimestamp(),
            // 'created_by' => $model->created_by,
            // 'updated_by' => $model->updated_by->toIso8601String(),
            // 'created_at' => $model->created_at->toIso8601String(),
        ];

    }
}
