<?php

namespace App\UseCases\Task\Requests;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Rule as SpatieRule;
use Illuminate\Validation\Rule;

class TaskRequest extends Data
{
    public ?int $id;

    #[SpatieRule('required', 'max:255')]
    public string $title;

    #[SpatieRule('boolean')]
    public bool $is_completed = false;

    public static function rules(): array
    {
        return [
            'title' => [
                Rule::unique('tasks', 'title')->ignore(request()->input('id')),
            ],
        ];
    }
}
