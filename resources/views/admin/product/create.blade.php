@extends('admin.layouts.master')

@push('styles')
    <style>
        .image-preview {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            position: relative;
            background-size: cover !important;
            background-position: center center !important;
        }

        .camera-icon {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        #image-upload {
            display: none;
        }

        #image-label {
            pointer-events: auto;
        }

        #image-label span,
        #image-label::after,
        #image-label::before {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header shadow-sm"
            style="background-color: #fff; padding: 20px 25px; border-radius: 5px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="margin: 0; font-size: 18px; color: #34395e;">
                <i class="fas fa-boxes" style="color: #6777ef; margin-right: 10px;"></i> Products
            </h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Product</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>Image</label>
                        <div id="image-preview" class="image-preview">
                            <div class="camera-icon" onclick="$('#image-upload').click()">
                                <i class="fas fa-camera"></i>
                            </div>
                            <input type="file" name="image" id="image-upload">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select name="category" class="form-control" id="">
                            <option value="">select</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" name="price" class="form-control" value="{{ old('price') }}">
                    </div>

                    <div class="form-group">
                        <label>Offer Price</label>
                        <input type="text" name="offer_price" class="form-control" value="{{ old('offer_price') }}">
                    </div>

                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="text" name="quantity" class="form-control" value="{{ old('quantity') }}">
                    </div>

                    <div class="form-group">
                        <label>Short Description</label>
                        <textarea name="short_description" class="form-control" id="">{{ old('short_description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Long Description</label>
                        <textarea name="long_description" class="form-control summernote" id="">{{ old('long_description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Sku</label>
                        <input type="text" name="sku" class="form-control" value="{{ old('sku') }}">
                    </div>

                    <div class="form-group">
                        <label>Seo Title</label>
                        <input type="text" name="seo_title" class="form-control" value="{{ old('seo_title') }}">
                    </div>

                    <div class="form-group">
                        <label>Seo Description</label>
                        <textarea name="seo_description" class="form-control" id="">{{ old('seo_description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Show at Home</label>
                        <select name="show_at_home" class="form-control" id="">
                            <option value="1">Yes</option>
                            <option selected value="0">No</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let defaultImage = "{{ asset('uploads/default-avatar.jpg') }}";
            $('.image-preview').css('background-image', 'url(' + defaultImage + ')');

            $('#image-upload').on('change', function() {
                const file = this.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = function(e) {
                    $('.image-preview').css('background-image', 'url(' + e.target.result + ')');
                };
                reader.readAsDataURL(file);
            });

        });
    </script>
@endpush
