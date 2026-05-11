@extends('admin.layouts.master')
@section('content')
    <section class="section">

        <div class="section-header shadow-sm"
            style="background-color: #fff; padding: 20px 25px; border-radius: 5px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="margin: 0; font-size: 18px; color: #34395e;"><i class="fas fa-user-lock"
                    style="color: #6777ef; margin-right: 10px;"></i> Create Role</h1>
        </div>
        
        <div class="card card-primary">
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Role Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Assign Permissions</label>
                        <hr>
                        <div class="row">
                            @foreach ($permissions as $group => $perms)
                                <div class="col-md-3 mb-4">
                                    <div class="card shadow-sm border">
                                        <div class="card-header bg-light py-2">
                                            <h6 class="mb-0 text-uppercase">{{ str_replace('_', ' ', $group) }}</h6>
                                        </div>
                                        <div class="card-body py-3">
                                            @foreach ($perms as $permission)
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="permissions[]"
                                                        id="perm_{{ $permission->id }}" value="{{ $permission->name }}">
                                                    <label class="custom-control-label"
                                                        for="perm_{{ $permission->id }}">{{ $permission->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right"><button class="btn btn-primary">Save Role</button></div>
            </form>
        </div>
    </section>
@endsection
