@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header shadow-sm"
            style="background-color: #fff; padding: 20px 25px; border-radius: 5px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="margin: 0; font-size: 18px; color: #34395e;"><i class="fas fa-key"
                    style="color: #6777ef; margin-right: 10px;"></i> Permission Management</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>All Permissions</h4>
                <div class="card-header-action"><a href="{{ route('admin.permissions.create') }}"
                        class="btn btn-primary">Create New</a></div>
            </div>
            <div class="card-body">
                <div class="table-responsive">{{ $dataTable->table() }}</div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
