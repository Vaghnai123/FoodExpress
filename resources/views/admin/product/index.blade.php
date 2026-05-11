@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header shadow-sm"
            style="background-color: #fff; padding: 20px 25px; border-radius: 5px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="margin: 0; font-size: 18px; color: #34395e;">
                <i class="fas fa-boxes" style="color: #6777ef; margin-right: 10px;"></i> Products
            </h1>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div id="accordion">
                    <div class="accordion">
                        <div class="accordion-header collapsed bg-primary text-light p-3 " role="button"
                            data-toggle="collapse" data-target="#panel-body-1" aria-expanded="false">
                            <h4>Menu Section Titles..</h4> 
                        </div>
                        <div class="accordion-body collapse" id="panel-body-1" data-parent="#accordion">
                            <form action="{{ route('admin.product-title.update') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="">Top Title</label>
                                    <input type="text" class="form-control" name="menu_top_title"
                                        value="{{ @$titles['menu_top_title'] }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Main Title</label>
                                    <input type="text" class="form-control" name="menu_main_title"
                                        value="{{ @$titles['menu_main_title'] }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Sub Title</label>
                                    <input type="text" class="form-control" name="menu_sub_title"
                                        value="{{ @$titles['menu_sub_title'] }}">
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-primary">
            <div class="card-header d-flex justify-content-between align-items-center" style="flex-wrap: nowrap; gap: 10px;">
                <h4 class="m-0" style="white-space: nowrap;">All Products</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.product.create') }}" class="btn btn-primary btn-sm shadow-sm" style="white-space: nowrap;">
                        <i class="fas fa-plus"></i> Create new
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
