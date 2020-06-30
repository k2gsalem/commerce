<?php

namespace App\Transformers\Users;

use App\Entities\Role;
use League\Fractal\TransformerAbstract;

/**
 * Class RolTransformer.
 */
class RoleTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = ['permissions'];

    /**
     * @param Role $model
     * @return array
     */
    public function transform(Role $model)
    {
        return [
            'id' => $model->uuid,
            'name' => $model->name,
            'created_at' => $model->created_at->getTimestamp(),
            'updated_at' => $model->updated_at->getTimestamp(),
        ];
    }

    /**
     * @param Role $model
     * @return \League\Fractal\Resource\Collection
     */
    public function includePermissions(Role $model)
    {
        return $this->collection($model->permissions, new PermissionTransformer());
    }
}
