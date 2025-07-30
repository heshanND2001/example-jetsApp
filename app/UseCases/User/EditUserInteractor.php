<?php

namespace App\UseCases\User;

use App\Models\User;
use Spatie\Permission\Models\Role;

class EditUserInteractor
{
    public function execute($id): array
    {
        $user = User::findOrFail($id);

        return [
            'user' => $user,
            'userRoles' => $user->roles->pluck('name')->all(),
            'roles' => Role::pluck('name')->toArray(),
        ];
    }
}
