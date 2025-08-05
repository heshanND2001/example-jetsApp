<?php

namespace App\UseCases\Task;

use App\Models\Task;

class DeleteTaskInteractor
{
    public function execute(Task $category): ?bool
    {
        return $category->delete();
    }
}
