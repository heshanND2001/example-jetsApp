<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TaskController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

Route::middleware('auth:sanctum')->get('/user', fn(Request $request) => $request->user());


Route::apiResource('tasks', TaskController::class);


Route::get('/test-api', fn() => response()->json(['status' => 'api.php is working']));


Route::get('/users', function (Request $request) {
    $query = User::with('roles');
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        });
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


Route::get('/roles', fn() => Role::all());
