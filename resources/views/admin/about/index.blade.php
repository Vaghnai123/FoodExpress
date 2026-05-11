@extends('admin.layouts.master')

@push('styles')
    <style>
        .image-preview {
            width: 250px;
            height: 150px;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            background-size: cover !important;
            background-position: center !important;
            border: 1px solid #e4e6fc;
            background-color: #f4f6f9;
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
                <i class="fas fa-info-circle" style="color: #6777ef; margin-right: 10px;"></i> About
            </h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Update About</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>Image</label>
                        <div id="image-preview" class="image-preview">
                            <div class="camera-icon" onclick="$('#image-upload').click()">
                                <i class="fas fa-camera"></i>
                            </div>
                            <input type="file" name="image" id="image-upload" />
                            <input type="hidden" name="old_image" value="{{ @$about->image }}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" value="{{ @$about->title }}">
                    </div>

                    <div class="form-group">
                        <label>Main Title</label>
                        <input type="text" name="main_title" class="form-control" value="{{ @$about->main_title }}">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control summernote">{!! @$about->description !!}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Youtube Video Link</label>
                        <input type="text" name="video_link" class="form-control" value="{{ @$about->video_link }}">
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
                'background-image': 'url({{ asset(@$about->image) }})'
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
