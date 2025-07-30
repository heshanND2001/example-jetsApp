<?php

namespace App\Http\Controllers\API;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UseCases\Task\DeleteTaskInteractor;
use App\UseCases\Task\ListTaskInteractor;
use App\UseCases\Task\Requests\TaskRequest;
use App\UseCases\Task\StoreTaskInteractor;
use App\UseCases\Task\UpdateTaskInteractor;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{

    public function index(ListTaskInteractor $listTaskInteractor)
    {
        return $listTaskInteractor->execute(request('search'));
    }

    // public function index(Request $request)
    // {
    //     $query = Task::query();

    //     if ($request->has('search')) {
    //         $search = $request->input('search');
    //         $query->where('title', 'like', "%{$search}%");
    //     }

    //     return response()->json([
    //         'data' => $query->latest()->get()
    //     ]);
    // }

    // Store a new task

    public function store(StoreTaskInteractor $storeTaskInteractor): JsonResponse
    {
        $Task = $storeTaskInteractor->execute(TaskRequest::validateAndCreate(request()->all()));
        return response()->json(['data' => $Task]);
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'title' => 'required|string|max:255',
    //     ]);
    //     $task = Task::create([
    //         'title' => $validated['title'],
    //         'is_completed' => false,
    //     ]);
    //     return response()->json(['data' => $task]);
    // }


    public function destroy(Task $task, DeleteTaskInteractor $deleteTaskInteractor): JsonResponse
    {
        $deleteTaskInteractor->execute($task);
        return response()->json(null, 204);
    }


    // public function destroy($id)
    // {
    //     $task = Task::findOrFail($id);
    //     $task->delete();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Task deleted successfully'
    //     ]);
    // }


    public function update(Task $task, UpdateTaskInteractor $updateTaskInteractor): JsonResponse
    {
        return response()->json($updateTaskInteractor->execute($task, TaskRequest::validateAndCreate(request())));
    }


    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //     ]);

    //     $task = Task::findOrFail($id);
    //     $task->update([
    //         'title' => $request->title,
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Task updated successfully',
    //         'data' => $task
    //     ]);
    // }
}
