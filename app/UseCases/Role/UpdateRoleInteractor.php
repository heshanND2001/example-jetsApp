<?php

namespace App\UseCases\Role;

use App\UseCases\Role\Requests\RoleRequest;
use Spatie\Permission\Models\Role;

class UpdateRoleInteractor
{
    public function execute(Role $role, RoleRequest $roleRequest): Role
    {
        if ($roleRequest->name) {
            $role->name = $roleRequest->name;
            $role->save();
        }

        if ($roleRequest->permissions) {
            $role->syncPermissions($roleRequest->permissions);
        }

        return $role;
    }
}


// namespace App\UseCases\Role;

// use App\UseCases\Role\Requests\RoleRequest;
// use Spatie\Permission\Models\Role;

// class UpdateRoleInteractor
// {
//     public function execute(RoleRequest $roleRequest)
//     {
//         $role = Role::findOrFail($roleRequest->id);
//         $role->name = $roleRequest->name;
//         $role->save();

//         $role->syncPermissions($roleRequest->permissions);

//         return to_route('roles.index');
//     }
// }
