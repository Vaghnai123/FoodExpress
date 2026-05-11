<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RoleDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
    public function index(RoleDataTable $dataTable)
    {
        return $dataTable->render('admin.roles.index');
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy('group_name');
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles,name', 'permissions' => 'nullable|array']);
        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);
        if ($request->has('permissions')) $role->syncPermissions($request->permissions);
        return redirect()->route('admin.roles.index')->with(['message' => 'Role Created Successfully', 'alert-type' => 'success']);
    }

    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        if ($role->name === 'Super Admin') throw ValidationException::withMessages(['Cannot edit Super Admin']);
        $permissions = Permission::all()->groupBy('group_name');
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);
        if ($role->name === 'Super Admin') throw ValidationException::withMessages(['Cannot edit Super Admin']);
        $request->validate(['name' => 'required|unique:roles,name,' . $id, 'permissions' => 'nullable|array']);
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);
        return redirect()->route('admin.roles.index')->with(['message' => 'Role Updated Successfully', 'alert-type' => 'success']);
    }

    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        if ($role->name === 'Super Admin') throw ValidationException::withMessages(['Cannot delete Super Admin']);
        $role->delete();
        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }
}
