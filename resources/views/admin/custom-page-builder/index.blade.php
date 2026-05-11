@extends('admin.layouts.master')

@section('content')
    <section class="section">

        <div class="section-header shadow-sm"
            style="background-color: #fff; padding: 20px 25px; border-radius: 5px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="margin: 0; font-size: 18px; color: #34395e;">
                <i class="fas fa-file-alt" style="color: #6777ef; margin-right: 10px;"></i> Custom Page Builder
            </h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>All Pages</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.custom-page-builder.create') }}" class="btn btn-primary">
                        Create new
                    </a>
                </div>
            </div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
