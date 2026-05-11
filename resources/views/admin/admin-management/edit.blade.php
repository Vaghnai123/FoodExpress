@extends('admin.layouts.master')
@section('content')
    <section class="section">

        <div class="section-header shadow-sm"
            style="background-color: #fff; padding: 20px 25px; border-radius: 5px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="margin: 0; font-size: 18px; color: #34395e;">
                <i class="fas fa-user-shield" style="color: #6777ef; margin-right: 10px;"></i> Edit Admin
            </h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Admin User</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.admin-management.update', $admin->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="form-group"><label>Name</label><input type="text" name="name" class="form-control"
                            value="{{ $admin->name }}"></div>
                    <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control"
                            value="{{ $admin->email }}"></div>
                    <div class="form-group">
                        <label>Assign Role</label>
                        <select name="role" class="form-control" {{ $admin->id == 1 ? 'disabled' : '' }}>
                            <option value="">Select Role</option>
                            @foreach ($roles as $roleName)
                                <option value="{{ $roleName }}"
                                    {{ isset($userRole) && $userRole == $roleName ? 'selected' : '' }}>{{ $roleName }}
                                </option>
                            @endforeach
                        </select>
                        @if ($admin->id == 1)
                            <small class="text-warning">Super Admin role cannot be changed.</small>
                            <input type="hidden" name="role" value="Super Admin">
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Password <small>(Leave empty to keep current password)</small></label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="form-group"><label>Confirm Password</label><input type="password"
                            name="password_confirmation" class="form-control"></div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
@endsection
