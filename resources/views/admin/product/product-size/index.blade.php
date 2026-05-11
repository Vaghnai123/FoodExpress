@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header shadow-sm"
            style="background-color: #fff; padding: 20px 25px; border-radius: 5px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="margin: 0; font-size: 18px; color: #34395e;">
                <i class="fas fa-th-list" style="color: #6777ef; margin-right: 10px;"></i> Products Variants
                ({{ $product->name }})
            </h1>
            <a href="{{ route('admin.product.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Create Product Size</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.product-size.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" name="name" class="form-control"
                                            placeholder="e.g. Small, Medium">
                                        <input type="hidden" value="{{ $product->id }}" name="product_id">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Price</label>
                                        <input type="text" name="price" class="form-control" placeholder="e.g. 5.00">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Create
                                    Size</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card card-primary">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 50px;">No.</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th class="text-center" style="width: 80px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sizes as $size)
                                        <tr>
                                            <td class="text-center" style="vertical-align: middle;">{{ ++$loop->index }}
                                            </td>
                                            <td style="vertical-align: middle;">{{ $size->name }}</td>
                                            <td style="vertical-align: middle;">{{ currencyPosition($size->price) }}</td>
                                            <td class="text-center" style="vertical-align: middle;">
                                                <a href='{{ route('admin.product-size.destroy', $size->id) }}'
                                                    class='btn btn-danger btn-sm delete-item'><i
                                                        class='fas fa-trash-alt'></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($sizes) === 0)
                                        <tr>
                                            <td colspan='4' class="text-center">No sizes found!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Create Product Options</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.product-option.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" name="name" class="form-control"
                                            placeholder="e.g. Extra Cheese">
                                        <input type="hidden" value="{{ $product->id }}" name="product_id">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Price</label>
                                        <input type="text" name="price" class="form-control" placeholder="e.g. 2.50">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Create
                                    Option</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card card-primary">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 50px;">No.</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th class="text-center" style="width: 80px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($options as $option)
                                        <tr>
                                            <td class="text-center" style="vertical-align: middle;">{{ ++$loop->index }}
                                            </td>
                                            <td style="vertical-align: middle;">{{ $option->name }}</td>
                                            <td style="vertical-align: middle;">{{ currencyPosition($option->price) }}</td>
                                            <td class="text-center" style="vertical-align: middle;">
                                                <a href='{{ route('admin.product-option.destroy', $option->id) }}'
                                                    class='btn btn-danger btn-sm delete-item'><i
                                                        class='fas fa-trash-alt'></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($options) === 0)
                                        <tr>
                                            <td colspan='4' class="text-center">No options found!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
