<?php

namespace App\UseCases\User\Requests;

use Spatie\LaravelData\Data;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Rule as SpatieRule;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Illuminate\Validation\Rules\Password;

class UserRequest extends Data
{
    public ?int $id;

    public string $email;

    #[SpatieRule('required'), Max(255)]
    public string $name;

    #[SpatieRule('required', 'sometimes'), Min(8), Confirmed]
    public string $password;

    #[SpatieRule('required', 'exists:roles,name')]
    public string $role;

    public static function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore(request()->input('id')),
                'max:255',
            ]
        ];
    }
}
