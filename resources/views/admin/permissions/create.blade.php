@extends('admin.layouts.master')
@section('content')
    <section class="section">
        
        <div class="section-header shadow-sm"
            style="background-color: #fff; padding: 20px 25px; border-radius: 5px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="margin: 0; font-size: 18px; color: #34395e;"><i class="fas fa-key"
                    style="color: #6777ef; margin-right: 10px;"></i> Create Permission</h1>
        </div>
        <div class="card card-primary">
            <form action="{{ route('admin.permissions.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Permission Name (e.g., 'view products')</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Module Group (e.g., 'Products', 'Settings')</label>
                        <input type="text" name="group_name" class="form-control" value="{{ old('group_name') }}"
                            required>
                    </div>
                </div>
                <div class="card-footer text-right"><button class="btn btn-primary">Save Permission</button></div>
            </form>
        </div>
    </section>
@endsection
