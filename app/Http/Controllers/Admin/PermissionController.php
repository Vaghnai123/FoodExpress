<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PermissionDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(PermissionDataTable $dataTable)
    {
        return $dataTable->render('admin.permissions.index');
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:permissions,name', 'group_name' => 'required|string|max:255']);
        Permission::create(['name' => $request->name, 'group_name' => strtolower(str_replace(' ', '_', $request->group_name)), 'guard_name' => 'web']);
        return redirect()->route('admin.permissions.index')->with(['message' => 'Permission Created Successfully', 'alert-type' => 'success']);
    }

    public function edit(string $id)
    {
        $permission = Permission::findOrFail($id);
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate(['name' => 'required|unique:permissions,name,' . $id, 'group_name' => 'required|string|max:255']);
        $permission = Permission::findOrFail($id);
        $permission->update(['name' => $request->name, 'group_name' => strtolower(str_replace(' ', '_', $request->group_name))]);
        return redirect()->route('admin.permissions.index')->with(['message' => 'Permission Updated Successfully', 'alert-type' => 'success']);
    }

    public function destroy(string $id)
    {
        Permission::findOrFail($id)->delete();
        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }
}
