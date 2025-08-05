<?php

namespace App\UseCases\Task;

use App\Models\Task;
use App\UseCases\Task\Requests\TaskRequest;

class UpdateTaskInteractor
{
    public function execute(Task $task, TaskRequest $taskRequest)
    {
        $task->update($taskRequest->toArray());
        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully',
            'data' => $task
        ]);
    }
}
