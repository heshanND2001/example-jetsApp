<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use App\Models\User;


Route::get('/', fn() => redirect('/login'));


Route::get('/register', fn() => Inertia::render('Auth/Register'))->name('register');

Route::get('/admin', fn() => Inertia::render('Admin'));


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');


    Route::get('/task', fn() => Inertia::render('Task'))->name('task');


    Route::get('/users', fn() => Inertia::render('Users/Users'))->name('users.page');
    Route::get('/roles', fn() => Inertia::render('Roles/Index'))->name('roles.page');


    Route::get('/logged-in-users', function () {
        $userIds = DB::table('sessions')
            ->where('last_activity', '>=', now()->subMinutes(config('session.lifetime'))->timestamp)
            ->pluck('user_id');

        $users = User::whereIn('id', $userIds)->get();

        return response()->json(['data' => $users]);
    });


    Route::post('/users/{user}/block', function (User $user) {
        $user->is_blocked = true;
        $user->save();
        DB::table('sessions')->where('user_id', $user->id)->delete();
        return response()->json(['message' => 'User blocked']);
    });

    Route::post('/users/{user}/unblock', function (User $user) {
        $user->is_blocked = false;
        $user->save();
        return response()->json(['message' => 'User unblocked']);
    });


    Route::resource('users', UserController::class)->middleware(['permission:users.index|users.create|users.edit|users.destroy']);
    Route::resource('roles', RoleController::class)->middleware(['permission:roles.index|roles.create|roles.edit|roles.destroy']);
});
