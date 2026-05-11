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
            background-position: center !important;
            border: 1px solid #e4e6fc;
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
            opacity: 0;
        }

        .image-preview:hover .camera-icon {
            opacity: 1;
        }

        #image-upload {
            display: none;
        }
    </style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header shadow-sm"
            style="background-color: #fff; padding: 20px 25px; border-radius: 5px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="margin: 0; font-size: 18px; color: #34395e;">
                <i class="fas fa-utensils" style="color: #6777ef; margin-right: 10px;"></i> Chefs
            </h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Chef</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.chefs.update', $chef->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Image</label>
                        <div id="image-preview" class="image-preview">
                            <div class="camera-icon" onclick="$('#image-upload').click()">
                                <i class="fas fa-camera"></i>
                            </div>
                            <input type="file" name="image" id="image-upload" />
                            <input type="hidden" name="old_image" value="{{ $chef->image }}"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $chef->name }}">
                    </div>

                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $chef->title }}">
                    </div>

                    <h6>Social Links</h6>
                    <hr>
                    <div class="form-group">
                        <label for="">Facebook <code>(Leave empty for hide)</code></label>
                        <input type="text" class="form-control" name="fb" value="{{ $chef->fb }}">
                    </div>
                    <div class="form-group">
                        <label for="">Linkedin <code>(Leave empty for hide)</code></label>
                        <input type="text" class="form-control" name="in" value="{{ $chef->in }}">
                    </div>
                    <div class="form-group">
                        <label for="">X <code>(Leave empty for hide)</code></label>
                        <input type="text" class="form-control" name="x" value="{{ $chef->x }}">
                    </div>
                    <div class="form-group">
                        <label for="">Web <code>(Leave empty for hide)</code></label>
                        <input type="text" class="form-control" name="web" value="{{ $chef->web }}">
                    </div>

                    <div class="form-group">
                        <label>Show at Home</label>
                        <select name="show_at_home" class="form-control" id="">
                            <option @selected($chef->show_at_home === 0) value="0">No</option>
                            <option @selected($chef->show_at_home === 1) value="1">Yes</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            <option @selected($chef->status === 1) value="1">Active</option>
                            <option @selected($chef->status === 0) value="0">Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('.image-preview').css({
                'background-image': 'url({{ asset($chef->image) }})',
            });

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
