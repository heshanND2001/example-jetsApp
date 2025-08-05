<?php

namespace App\UseCases\User;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Inertia\Inertia;

class ListUserInteractor
{
    public function execute()
    {
        return Inertia::render('Users/Users', [
            'users' => User::with('roles')->get(),
            'roles' => Role::all()
        ]);
    }
}
