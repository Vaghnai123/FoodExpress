@extends('admin.layouts.master')

@push('styles')
    <style>
        .image-preview {
            width: 200px;
            height: 150px;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            background-size: contain !important;
            background-repeat: no-repeat !important;
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

        input[type="file"].hidden-upload {
            display: none;
        }
    </style>
@endpush

@section('content')
    <section class="section">

        <div class="section-header shadow-sm"
            style="background-color: #fff; padding: 20px 25px; border-radius: 5px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="margin: 0; font-size: 18px; color: #34395e;">
                <i class="fas fa-mobile-alt" style="color: #6777ef; margin-right: 10px;"></i> App Download Section
            </h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Section</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.app-download.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Image</label>
                                <div id="image-preview-1" class="image-preview">
                                    <div class="camera-icon" onclick="$('#image-upload-1').click()">
                                        <i class="fas fa-camera"></i>
                                    </div>
                                    <input type="file" name="image" id="image-upload-1" class="hidden-upload" />
                                    <input type="hidden" name="old_image" value="{{ @$appSection->image }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Background</label>
                                <div id="image-preview-2" class="image-preview">
                                    <div class="camera-icon" onclick="$('#image-upload-2').click()">
                                        <i class="fas fa-camera"></i>
                                    </div>
                                    <input type="file" name="background" id="image-upload-2" class="hidden-upload" />
                                    <input type="hidden" name="old_background" value="{{ @$appSection->background }}" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" class="form-control" name="title" value="{{ @$appSection->title }}">
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="short_description" id="" class="form-control">{{ @$appSection->short_description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Play Store Link <code>(Leave empty for hide)</code></label>
                        <input type="text" class="form-control" name="play_store_link" value="{{ @$appSection->play_store_link }}">
                    </div>

                    <div class="form-group">
                        <label for="">Apple Store Link <code>(Leave empty for hide)</code></label>
                        <input type="text" class="form-control" name="apple_store_link" value="{{ @$appSection->apple_store_link }}">
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
            
            $('#image-preview-1').css('background-image', 'url({{ asset(@$appSection->image) }})');
            $('#image-preview-2').css('background-image', 'url({{ asset(@$appSection->background) }})');

            // Live preview for the first image
            $('#image-upload-1').on('change', function() {
                const file = this.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-preview-1').css('background-image', 'url(' + e.target.result + ')');
                };
                reader.readAsDataURL(file);
            });

            // Live preview for the second image (background)
            $('#image-upload-2').on('change', function() {
                const file = this.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-preview-2').css('background-image', 'url(' + e.target.result + ')');
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endpush
