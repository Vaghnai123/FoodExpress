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

<div class="tab-pane fade show" id="logo-setting" role="tabpanel" aria-labelledby="home-tab4">
    <div class="card shadow-none">
        <div class="card-body p-0">
            <form action="{{ route('admin.logo-setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <!-- Logo Upload -->
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label>Logo</label>
                            <div id="image-preview-1" class="image-preview">
                                <div class="camera-icon" onclick="$('#image-upload-1').click()">
                                    <i class="fas fa-camera"></i>
                                </div>
                                <input type="file" name="logo" id="image-upload-1" class="hidden-upload" />
                            </div>
                        </div>
                    </div>

                    <!-- Footer Logo Upload -->
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label>Footer Logo</label>
                            <div id="image-preview-2" class="image-preview">
                                <div class="camera-icon" onclick="$('#image-upload-2').click()">
                                    <i class="fas fa-camera"></i>
                                </div>
                                <input type="file" name="footer_logo" id="image-upload-2" class="hidden-upload" />
                            </div>
                        </div>
                    </div>

                    <!-- Favicon Upload -->
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label>Favicon</label>
                            <div id="image-preview-3" class="image-preview">
                                <div class="camera-icon" onclick="$('#image-upload-3').click()">
                                    <i class="fas fa-camera"></i>
                                </div>
                                <input type="file" name="favicon" id="image-upload-3" class="hidden-upload" />
                            </div>
                        </div>
                    </div>

                    <!-- Breadcrumb Upload -->
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label>Breadcrumb</label>
                            <div id="image-preview-4" class="image-preview">
                                <div class="camera-icon" onclick="$('#image-upload-4').click()">
                                    <i class="fas fa-camera"></i>
                                </div>
                                <input type="file" name="breadcrumb" id="image-upload-4" class="hidden-upload" />
                            </div>
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary px-4">Save</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {

            $('#image-preview-1').css('background-image', 'url({{ asset(config("settings.logo")) }})');
            $('#image-preview-2').css('background-image', 'url({{ asset(config("settings.footer_logo")) }})');
            $('#image-preview-3').css('background-image', 'url({{ asset(config("settings.favicon")) }})');
            $('#image-preview-4').css('background-image', 'url({{ asset(config("settings.breadcrumb")) }})');

            function setupLivePreview(inputId, previewId) {
                $('#' + inputId).on('change', function() {
                    const file = this.files[0];
                    if (!file) return;

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#' + previewId).css('background-image', 'url(' + e.target.result + ')');
                    };
                    reader.readAsDataURL(file);
                });
            }

            setupLivePreview('image-upload-1', 'image-preview-1');
            setupLivePreview('image-upload-2', 'image-preview-2');
            setupLivePreview('image-upload-3', 'image-preview-3');
            setupLivePreview('image-upload-4', 'image-preview-4');

        });
    </script>
@endpush
