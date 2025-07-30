<?php

namespace App\UseCases\User;

use App\Models\User;
use App\UseCases\User\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class StoreUserInteractor
{
    public function execute(UserRequest $userRequest)
    {
        $user = User::create([
            'name' => $userRequest->name,
            'email' => $userRequest->email,
            'password' => Hash::make($userRequest->password),
        ]);

        // Assign role using Spatie
        $user->syncRoles($userRequest->role);

        return $user;
    }
}
