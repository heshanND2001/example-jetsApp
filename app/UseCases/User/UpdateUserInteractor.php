<?php

namespace App\UseCases\User;

use App\Models\User;
use App\UseCases\User\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UpdateUserInteractor
{
    public function execute(User $user, UserRequest $userRequest): User
    {
        $user->name = $userRequest->name;
        $user->email = $userRequest->email;

        if (!empty($userRequest->password)) {
            $user->password = Hash::make($userRequest->password);
        }

        $user->save();

        $user->syncRoles($userRequest->role);

        return $user;
    }
}
