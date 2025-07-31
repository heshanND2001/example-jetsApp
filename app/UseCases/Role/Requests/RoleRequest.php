<?php

namespace App\UseCases\Role\Requests;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Rule as SpatieRule;
use Illuminate\Validation\Rule;

class RoleRequest extends Data
{
    public ?string $id;

    public string $name;

    #[SpatieRule('required', 'array')]
    public ?array $permissions;

    public static function rules(): array
    {

        $roleId = request()->route('role')?->id;

        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($roleId),
            ],
            'permissions' => ['required', 'array'],
        ];
    }
}
