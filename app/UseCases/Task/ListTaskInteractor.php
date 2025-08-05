<?php

namespace App\UseCases\Task;

use App\Models\Task;

class ListTaskInteractor
{
    public function execute($search)
    {

        $query = Task::query();

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        return response()->json([
            'data' => $query->latest()->get()
        ]);
    }
}
