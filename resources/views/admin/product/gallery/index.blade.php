@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header shadow-sm"
            style="background-color: #fff; padding: 20px 25px; border-radius: 5px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="margin: 0; font-size: 18px; color: #34395e;">
                <i class="fas fa-images" style="color: #6777ef; margin-right: 10px;"></i> Products Gallery
                ({{ $product->name }})
            </h1>
            <a href="{{ route('admin.product.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Upload New Image</h4>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <form action="{{ route('admin.product-gallery.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                            <input type="hidden" value="{{ $product->id }}" name="product_id">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Upload
                                Image</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>All Images</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-md">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 150px;">Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($images as $image)
                                <tr>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <img style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px; border: 2px solid #f4f6f9; padding: 2px;"
                                            src="{{ asset($image->image) }}" alt="Product Image">
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <a href='{{ route('admin.product-gallery.destroy', $image->id) }}'
                                            class='btn btn-danger delete-item'><i class='fas fa-trash-alt'></i> Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            @if (count($images) === 0)
                                <tr>
                                    <td colspan='2' class="text-center">No images found! Please upload some.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Bootstrap custom file input behaviour
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
        });
    </script>
@endpush
