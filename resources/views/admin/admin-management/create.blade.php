@extends('admin.layouts.master')
@section('content')
    <section class="section">

        <div class="section-header shadow-sm"
            style="background-color: #fff; padding: 20px 25px; border-radius: 5px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="margin: 0; font-size: 18px; color: #34395e;">
                <i class="fas fa-user-shield" style="color: #6777ef; margin-right: 10px;"></i> Create Admin
            </h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Admin User</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.admin-management.store') }}" method="POST">
                    @csrf
                    <div class="form-group"><label>Name</label><input type="text" name="name" class="form-control"
                            value="{{ old('name') }}"></div>
                    <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control"
                            value="{{ old('email') }}"></div>
                    <div class="form-group">
                        <label>Assign Role</label>
                        <select name="role" class="form-control">
                            <option value="">Select Role</option>
                            @foreach ($roles as $roleName)
                                <option value="{{ $roleName }}" {{ old('role') == $roleName ? 'selected' : '' }}>
                                    {{ $roleName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group"><label>Password</label><input type="password" name="password"
                            class="form-control"></div>
                    <div class="form-group"><label>Confirm Password</label><input type="password"
                            name="password_confirmation" class="form-control"></div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </section>
@endsection
