<?php

namespace App\UseCases\Role;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class EditRoleInteractor
{
    public function execute(string $id): array
    {
        $role = Role::findOrFail($id); // use findOrFail for safety

        return [
            'role' => $role,
            'rolePermissions' => $role->permissions()->pluck('name')->all(),
            'permissions' => Permission::pluck('name')->all(),
        ];
    }
}
