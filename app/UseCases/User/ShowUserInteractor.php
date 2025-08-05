<?php

namespace App\UseCases\User;

use App\Models\User;
use Inertia\Inertia;

class ShowUserInteractor
{
    public function execute(User $user)
    {
        return Inertia::render('Users/show', [
            'user' => $user,
            'userRoles' => $user->roles->pluck('name')->all(),
        ]);
    }
}
