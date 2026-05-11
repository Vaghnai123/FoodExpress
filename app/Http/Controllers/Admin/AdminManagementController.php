<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AdminManagementController extends Controller
{
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('admin.admin-management.index');
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('admin.admin-management.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role' => ['required'],
            'password' => ['required', 'confirmed', 'min:5']
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = 'admin';
        $user->password = bcrypt($request->password);
        $user->avatar = null;
        $user->save();
        $user->assignRole($request->role);

        return to_route('admin.admin-management.index')->with(['message' => 'Admin Created Successfully', 'alert-type' => 'success']);
    }

    public function edit(string $id): View
    {
        $admin = User::findOrFail($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $admin->roles->pluck('name')->first();
        return view('admin.admin-management.edit', compact('admin', 'roles', 'userRole'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        if ($id == 1 && $request->role !== 'Super Admin') {
            throw ValidationException::withMessages(['You cannot change the Super Admin role']);
        }

        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $id],
            'role' => ['required'],
        ]);

        if ($request->has('password') && $request->filled('password')) {
            $request->validate(['password' => ['confirmed', 'min:5']]);
            $user->password = bcrypt($request->password);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        if ($user->id != 1) {
            $user->syncRoles([$request->role]);
        }

        return to_route('admin.admin-management.index')->with(['message' => 'Admin Updated Successfully', 'alert-type' => 'success']);
    }

    public function destroy(string $id)
    {
        if ($id == 1) throw ValidationException::withMessages(['you can not delete super admin']);
        try {
            User::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
