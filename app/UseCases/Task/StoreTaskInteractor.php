<?php

namespace App\UseCases\Task;

use App\Models\Task;
use App\UseCases\Task\Requests\TaskRequest;

class StoreTaskInteractor
{
    public function execute(TaskRequest $taskRequest)
    {
        return Task::create($taskRequest->toArray());
    }
}
