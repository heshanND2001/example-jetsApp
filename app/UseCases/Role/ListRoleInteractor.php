<?php

namespace App\UseCases\Role;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ListRoleInteractor
{
    public function execute(): array
    {
        return [
            'roles' => Role::with('permissions')->get(),
            'permissions' => Permission::pluck('name'),
        ];
    }
}
