<?php

namespace App\Services\Installation;

use Closure;
use App\Entities\Role;
use App\Entities\User;
use App\Entities\Permission;
use Illuminate\Validation\ValidationException;
use App\Services\Installation\Events\ApplicationWasInstalled;

/**
 * Class InstallAppHandler.
 */
class InstallAppHandler
{
    /**
     * @var array|\Illuminate\Support\Collection
     */
    public $roles = [
        ['name' => 'Administrator'],
    ];

    /**
     * @var array|\Illuminate\Support\Collection
     */
    public $permissions = [
        'users' => [
            ['name' => 'List users'],
            ['name' => 'Create users'],
            ['name' => 'Delete users'],
            ['name' => 'Update users'],
        ],
        'roles' => [
            ['name' => 'List roles'],
            ['name' => 'Create roles'],
            ['name' => 'Delete roles'],
            ['name' => 'Update roles'],
        ],
        'permissions' => [
            ['name' => 'List permissions'],
        ],
        'config_status' => [
            ['name' => 'List config status'],
            ['name' => 'Create config status'],
            ['name' => 'Delete config status'],
            ['name' => 'Update config status'],
        ],
        'config_order_type' => [
            ['name' => 'List order type'],
            ['name' => 'Create order type'],
            ['name' => 'Delete order type'],
            ['name' => 'Update order type'],
        ],
        'config_suppliers' => [
            ['name' => 'List config supplier'],
            ['name' => 'Create config supplier'],
            ['name' => 'Delete config supplier'],
            ['name' => 'Update config supplier'],
        ],
        'config_vendor' => [
            ['name' => 'List config vendor'],
            ['name' => 'Create config vendor'],
            ['name' => 'Delete config vendor'],
            ['name' => 'Update config vendor'],
        ],
        'config_prod_cat' => [
            ['name' => 'List product category'],
            ['name' => 'Create product category'],
            ['name' => 'Delete product category'],
            ['name' => 'Update product category'],
        ],
        'config_prod_sub_cat' => [
            ['name' => 'List product sub category'],
            ['name' => 'Create product sub category'],
            ['name' => 'Delete product sub category'],
            ['name' => 'Update product sub category'],
        ],
        'supplier' => [
            ['name' => 'List supplier'],
            ['name' => 'Create supplier'],
            ['name' => 'Delete supplier'],
            ['name' => 'Update supplier'],
        ],
        'vendor' => [
            ['name' => 'List vendor'],
            ['name' => 'Create vendor'],
            ['name' => 'Delete vendor'],
            ['name' => 'Update vendor'],
        ],
        'item' => [
            ['name' => 'List item'],
            ['name' => 'Create item'],
            ['name' => 'Delete item'],
            ['name' => 'Update item'],
        ],
        'item_variant' => [
            ['name' => 'List item variant'],
            ['name' => 'Create item variant'],
            ['name' => 'Delete item variant'],
            ['name' => 'Update item variant'],
        ],
        'stock' => [
            ['name' => 'List stock'],
            ['name' => 'Create stock'],
            ['name' => 'Delete stock'],
            ['name' => 'Update stock'],
        ],
        'item_variant_group' => [
            ['name' => 'List item variant group'],
            ['name' => 'Create item variant group'],
            ['name' => 'Delete item variant group'],
            ['name' => 'Update item variant group'],
        ],
        'stock_tracker' => [
            ['name' => 'List stock tracker'],
            ['name' => 'Create stock tracker'],
            ['name' => 'Delete stock tracker'],
            ['name' => 'Update stock tracker'],
        ],
        'vendor_store' => [
            ['name' => 'List vendor store'],
            ['name' => 'Create vendor store'],
            ['name' => 'Delete vendor store'],
            ['name' => 'Update vendor store'],
        ],
    ];

    /**
     * @var
     */
    public $adminUser;

    /**
     * InstallAppHandler constructor.
     */
    public function __construct()
    {
        $this->roles = collect($this->roles);
        $this->permissions = collect($this->permissions);
    }

    /**
     * @param $installationData
     * @param \Closure $next
     * @return mixed
     */
    public function handle($installationData, Closure $next)
    {
        $this->createRoles()->createPermissions()->createAdminUser((array) $installationData)->assignAdminRoleToAdminUser()->assignAllPermissionsToAdminRole();
        event(new ApplicationWasInstalled($this->adminUser, $this->roles, $this->permissions));

        return $next($installationData);
    }

    /**
     * @return $this
     */
    public function createRoles()
    {
        $this->roles = $this->roles->map(function ($role) {
            return Role::create($role);
        });

        return $this;
    }

    /**
     * @return $this
     */
    public function createPermissions()
    {
        $this->permissions = $this->permissions->map(function ($group) {
            return collect($group)->map(function ($permission) {
                return Permission::create($permission);
            });
        });

        return $this;
    }

    /**
     * @param array $attributes
     * @return $this
     * @throws ValidationException
     */
    public function createAdminUser(array $attributes = [])
    {   $attributes['name']="Admin";
        $attributes['email']="admin@gmail.com";
        $attributes['password']="12345678";
        $attributes['password_confirmation']="12345678";
        $validator = validator($attributes, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $this->adminUser = User::create([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'password' => $attributes['password'],
        ]);

        return $this;
    }

    /**
     * @return $this
     */
    public function assignAdminRoleToAdminUser()
    {
        $this->adminUser->assignRole('Administrator');

        return $this;
    }

    /**
     * @return $this
     */
    public function assignAllPermissionsToAdminRole()
    {
        $role = Role::where('name', 'Administrator')->firstOrFail();
        $this->permissions->flatten()->each(function ($permission) use ($role) {
            $role->givePermissionTo($permission);
        });

        return $this;
    }
}
