<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TaskController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Task API routes
Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/task', [TaskController::class, 'task']);
Route::delete('/task/{id}', [TaskController::class, 'destroy']);
Route::put('/task/{id}', [TaskController::class, 'update']);
Route::apiResource('tasks', TaskController::class);

// Test route
Route::get('/test-api', function () {
    return response()->json(['status' => 'api.php is working']);
});

Route::get('/users', function (Illuminate\Http\Request $request) {
    $query = User::query();
    if ($request->has('search')) {
        $search = $request->input('search');
        $query->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%");
    }
    return response()->json(['data' => $query->latest()->get()]);
});

Route::get('/users/{id}', function ($id) {
    $user = User::with('roles')->findOrFail($id);
    return response()->json(['data' => $user]);
});

Route::delete('/users/{id}', function ($id) {
    $user = User::findOrFail($id);
    $user->delete();
    return response()->json(['message' => 'User deleted']);
});

Route::get('/roles', function () {
    return Role::all();
});

Route::get('/users', function () {
    return response()->json([
        'data' => User::with('roles')->get()
    ]);
});

Route::get('/users', function (Illuminate\Http\Request $request) {
    $query = User::with('roles');

    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        });
    }

    return response()->json([
        'data' => $query->latest()->get()
    ]);
});
