<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


use Illuminate\Support\Facades\DB;
use App\Models\User;


// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

// Register route
Route::get('/register', function () {
    return Inertia::render('Auth/Register');
})->name('register');

Route::get('/admin', function () {
    return Inertia::render('Admin');
});


// Dashboard route with auth
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

// Task UI route
Route::middleware(['auth'])->group(function () {
    Route::get('/task', function () {
        return Inertia::render('Task');
    })->name('task');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/users', function () {
        return Inertia::render('Users/Users');
    })->name('users.index');
});

// Route::middleware(['auth'])->group(function () {
//     Route::get('/users', function () {
//         return Inertia::render('Users/Users');
//     })->name('users.index');
// });

Route::get('/users', function () {
    return Inertia::render('Users/Users');
})->name('users.index');

// Route::middleware(['auth'])->group(function () {
//     Route::get('/roles', function () {
//         return Inertia::render('Roles/Index');
//     })->name('roles.index');
// });



Route::get('/logged-in-users', function () {
    $userIds = DB::table('sessions')
        ->where('last_activity', '>=', now()->subMinutes(config('session.lifetime'))->timestamp)
        ->pluck('user_id');

    $users = User::whereIn('id', $userIds)->get();

    return response()->json([
        'data' => $users,
    ]);
})->middleware(['auth', 'verified']);



Route::post('/users/{user}/block', function (User $user) {
    $user->is_blocked = true;
    $user->save();

    DB::table('sessions')->where('user_id', $user->id)->delete();

    return response()->json(['message' => 'User blocked']);
})->middleware(['auth', 'verified']);

Route::post('/users/{user}/unblock', function (User $user) {
    $user->is_blocked = false;
    $user->save();

    return response()->json(['message' => 'User unblocked']);
})->middleware(['auth', 'verified']);



Route::resource('users', UserController::class);


Route::resource('users', UserController::class)
    ->only(['create', 'store'])
    ->middleware(["permission:users.create"]);

Route::resource('users', UserController::class)
    ->only(['edit', 'update'])
    ->middleware(["permission:users.edit"]);

Route::resource('users', UserController::class)
    ->only(['destroy'])
    ->middleware(["permission:users.destroy"]);

// Route::resource('users', UserController::class)
//     ->only(['index', 'show'])
//     ->middleware(["permission:users.create | users.edit | users.destroy | users.index"]);

Route::resource('roles', RoleController::class)
    ->only(['create', 'store'])
    ->middleware(["permission:roles.create"]);

Route::resource('roles', RoleController::class)
    ->only(['edit', 'update'])
    ->middleware(["permission:roles.edit"]);

Route::resource('roles', RoleController::class)
    ->only(['destroy'])
    ->middleware(["permission:roles.destroy"]);

// Route::resource('roles', RoleController::class)
//     ->only(['index', 'show'])
//     ->middleware(["permission:roles.create | roles.edit | roles.destroy | roles.index"]);



Route::resource('roles', RoleController::class);



// Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');



// Route::middleware(['auth'])->group(function () {
//     Route::get('/users/create', function () {
//         return Inertia::render('Users/Create');
//     })->name('users.create');
// });
