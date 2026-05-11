@extends('admin.layouts.master')

@push('styles')
    <style>
        .image-preview {
            width: 200px;
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
                <i class="fas fa-concierge-bell" style="color: #6777ef; margin-right: 10px;"></i> Counter
            </h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Counter</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.counter.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Background</label>
                        <div id="image-preview" class="image-preview">
                            <div class="camera-icon" onclick="$('#image-upload').click()">
                                <i class="fas fa-camera"></i>
                            </div>
                            <input type="file" name="background" id="image-upload" />
                            <input type="hidden" name="old_background" value="{{ @$counter->background }}" />
                        </div>
                    </div>

                    <h6>Counter One</h6>
                    <hr>
                    <div class="form-group">
                        <label for="">Counter Icon One</label>
                        <br>
                        <button class="btn btn-secondary" role="iconpicker" name="counter_icon_one" data-icon="{{ @$counter->counter_icon_one }}"></button>
                    </div>

                    <div class="form-group">
                        <label for="">Counter count One</label>
                        <input type="text" class="form-control" name="counter_count_one" value="{{ @$counter->counter_count_one }}">
                    </div>

                    <div class="form-group">
                        <label for="">Counter count Name</label>
                        <input type="text" class="form-control" name="counter_name_one" value="{{ @$counter->counter_name_one }}">
                    </div>

                    <h6>Counter Two</h6>
                    <hr>
                    <div class="form-group">
                        <label for="">Counter Icon Two</label>
                        <br>
                        <button class="btn btn-secondary" role="iconpicker" name="counter_icon_two" data-icon="{{ @$counter->counter_icon_two }}"></button>
                    </div>

                    <div class="form-group">
                        <label for="">Counter count Two</label>
                        <input type="text" class="form-control" name="counter_count_two" value="{{ @$counter->counter_count_two }}">
                    </div>

                    <div class="form-group">
                        <label for="">Counter count Name Two</label>
                        <input type="text" class="form-control" name="counter_name_two" value="{{ @$counter->counter_name_two }}">
                    </div>

                    <h6>Counter Three</h6>
                    <hr>
                    <div class="form-group">
                        <label for="">Counter Icon Three</label>
                        <br>
                        <button class="btn btn-secondary" role="iconpicker" name="counter_icon_three" data-icon="{{ @$counter->counter_icon_three }}"></button>
                    </div>

                    <div class="form-group">
                        <label for="">Counter Count Three</label>
                        <input type="text" class="form-control" name="counter_count_three" value="{{ @$counter->counter_count_three }}">
                    </div>

                    <div class="form-group">
                        <label for="">Counter count Name Theree</label>
                        <input type="text" class="form-control" name="counter_name_three" value="{{ @$counter->counter_name_three }}">
                    </div>

                    <h6>Counter Four</h6>
                    <hr>
                    <div class="form-group">
                        <label for="">Counter Icon Four</label>
                        <br>
                        <button class="btn btn-secondary" role="iconpicker" name="counter_icon_four" data-icon="{{ @$counter->counter_icon_four }}"></button>
                    </div>

                    <div class="form-group">
                        <label for="">Counter Count Four</label>
                        <input type="text" class="form-control" name="counter_count_four" value="{{ @$counter->counter_count_four }}">
                    </div>

                    <div class="form-group">
                        <label for="">Counter count Name Four</label>
                        <input type="text" class="form-control" name="counter_name_four" value="{{ @$counter->counter_name_four }}">
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
                'background-image': 'url({{ asset(@$counter->background) }})'
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
