<?php

namespace App\Transformers\Profile;

use App\Entities\Profile\UserAddress;
use League\Fractal\TransformerAbstract;

class UserAddressTransformer extends TransformerAbstract
{
    public function transform(UserAddress $model)
    {
        return [
            'id' => (int) $model->id,
            'user_id' => (int) $model->user_id,
            'user_name' => (string) $model->user_name,
            'user_contact' => (string) $model->user_contact,
            'address_st1' => (string) $model->address_st1,
            'address_st2' => (string) $model->address_st2,
            'landmark' => (string) $model->landmark,
            'area' => (string) $model->area,
            'city_town' => (string) $model->city_town,
            'state' => (string) $model->state,
            'pincode' => (int) $model->pincode,
            'created_at' => (string)$model->updated_at->getTimestamp(),
            'updated_at' => (string)$model->updated_at->getTimestamp(),
        ];
    }

}
