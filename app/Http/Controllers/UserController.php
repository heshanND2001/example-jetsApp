<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\UseCases\User\EditUserInteractor;
use App\UseCases\User\ListUserInteractor;
use App\UseCases\User\Requests\UserRequest;
use App\UseCases\User\ShowUserInteractor;
use App\UseCases\User\StoreUserInteractor;
use App\UseCases\User\UpdateUserInteractor;
use App\UseCases\User\UpdateUserInteractor as UsersUpdateUserInteractor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(ListUserInteractor $listUserInteractor)
    {
        return $listUserInteractor->execute();
    }

    // public function index()
    // {
    //     return Inertia::render('Users/Users', [
    //         'users' => User::with('roles')->get(),
    //         'roles' => Role::all()
    //     ]);
    // }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("Users/Create", [
            'roles' => Role::pluck('name')->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreUserInteractor $storeUserInteractor)
    {
        $data = UserRequest::validateAndCreate(request());
        $user = $storeUserInteractor->execute($data);

        return to_route('users.index')->with('success', 'User created successfully');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8|confirmed',
    //         'role' => 'required|string|exists:roles,name', // Optional but good
    //     ]);

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     $user->syncRoles($request->role);

    //     return to_route("users.index");
    // }




    /**
     * Display the specified resource.
     */

    public function show(User $user, ShowUserInteractor $showUserInteractor)
    {
        return $showUserInteractor->execute($user);
    }

    // public function show(string $id)
    // {
    //     $user = User::with('roles')->findOrFail($id);
    //     return Inertia::render('Users/show', [
    //         'user' => $user,
    //         'userRoles' => $user->roles->pluck('name')->all(),
    //     ]);
    // }

    /**
     * Show the form for editing the specified resource.
     */


    public function edit(int $id, EditUserInteractor $interactor)
    {
        return $interactor->execute($id);
    }


    // public function edit(string $id)
    // {
    //     $user = User::find($id);
    //     return Inertia::render('Users/Edit', [
    //         'user' => $user,
    //         'userRoles' => $user->roles->pluck('name')->all(),
    //         'roles' => Role::pluck('name')->toArray(),

    //     ]);
    // }

    /**
     * Update the specified resource in storage.
     */

    public function update(string $id, UpdateUserInteractor $interactor)
    {

        $userRequest = UserRequest::validateAndCreate(request());

        $user = User::findOrFail($id);
        $interactor->execute($user, $userRequest);

        return to_route("users.index")->with('success', 'User updated successfully');
    }





    // public function update(Request $request, string $id)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => [
    //             'required',
    //             'string',
    //             'email',
    //             'max:255',
    //             Rule::unique('users')->ignore($id),
    //         ],
    //         'password' => 'nullable|string|min:8',
    //     ]);

    //     $user = User::findOrFail($id);

    //     $user->name = $request->name;
    //     $user->email = $request->email;

    //     if ($request->filled('password')) {
    //         $user->password = Hash::make($request->password);
    //     }

    //     $user->save();

    //     $user->syncRoles($request->role);

    //     return to_route("users.index")->with('success', 'User updated successfully');

    //     // dd($request->role);
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
