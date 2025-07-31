<?php

namespace App\Http\Controllers;

use App\UseCases\Role\EditRoleInteractor;
use App\UseCases\Role\ListRoleInteractor;
use App\UseCases\Role\Requests\RoleRequest;
use App\UseCases\Role\ShowRoleInteractor;
use App\UseCases\Role\StoreRoleInteractor;
use App\UseCases\Role\UpdateRoleInteractor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(ListRoleInteractor $listRoleInteractor)
    {
        $data = $listRoleInteractor->execute();

        return Inertia::render('Roles/Index', [
            'roles' => $data['roles'],
            'permissions' => $data['permissions'],
        ]);
    }


    // public function index()
    // {
    //     $roles = Role::with('permissions')->get();
    //     $permissions = Permission::pluck('name');

    //     return Inertia::render('Roles/Index', [
    //         'roles' => $roles,
    //         'permissions' => $permissions,
    //     ]);
    // }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Roles/Create', [
            'permissions' => Permission::pluck("name")->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(RoleRequest $roleRequest, StoreRoleInteractor $storeRoleInteractor)
    {
        $storeRoleInteractor->execute($roleRequest);

        return to_route('roles.index');
    }


    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255|unique:roles',
    //         'permissions' => 'required',
    //     ]);

    //     $role = Role::create(['name' => $request->name]);
    //     $role->syncPermissions($request->permissions);

    //     return to_route('roles.index');

    //     // dd($request->all());
    // }

    /**
     * Display the specified resource.
     */

    public function show(Role $role, ShowRoleInteractor $showRoleInteractor)
    {
        $roleData = $showRoleInteractor->execute($role);

        return Inertia::render('Roles/Show', [
            'role' => $roleData,
            'rolePermissions' => $roleData->permissions()->pluck('name')->all(),
        ]);
    }

    // public function show(string $id)
    // {
    //     $role = Role::find($id);
    //     return Inertia::render('Roles/show', [
    //         'role' => $role,
    //         'rolePermissions' => $role->permissions()->pluck('name')->all(),
    //     ]);
    // }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(string $id, EditRoleInteractor $editRoleInteractor)
    {
        $showRoleData = $editRoleInteractor->execute($id);

        return Inertia::render('Roles/Edit', $showRoleData);
    }

    // public function edit(string $id)
    // {
    //     $role = Role::find($id);
    //     return Inertia::render('Roles/Edit', [
    //         'role' => $role,
    //         'rolePermissions' => $role->permissions()->pluck('name')->all(),
    //         'permissions' => Permission::pluck("name")->all()
    //     ]);
    // }

    /**
     * Update the specified resource in storage.
     */

    public function update(Role $role, UpdateRoleInteractor $updateRoleInteractor)
    {
        $roleRequest = RoleRequest::validateAndCreate(request());

        $updateRoleInteractor->execute($role, $roleRequest);

        return to_route('roles.index')->with('success', 'Role updated.');
    }


    // public function update(Request $request, string $id)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'permissions' => 'required',
    //     ]);

    //     $role = Role::find($id);
    //     $role->name = $request->name;
    //     $role->save();

    //     $role->syncPermissions($request->permissions);

    //     return to_route('roles.index');
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Role::findOrFail($id)->delete();

        return redirect()->route('roles.index')->with('success', 'Role deleted.');
    }
}
