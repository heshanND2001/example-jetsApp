<?php

namespace App\UseCases\Role;

use App\UseCases\Role\Requests\RoleRequest;
use Spatie\Permission\Models\Role;

class StoreRoleInteractor
{
    public function execute(RoleRequest $roleRequest): Role
    {
        $role = Role::create(['name' => $roleRequest->name]);
        $role->syncPermissions($roleRequest->permissions);

        return $role;
    }
}
