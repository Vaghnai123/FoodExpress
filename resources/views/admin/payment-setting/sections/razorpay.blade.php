<div class="tab-pane fade show" id="razorpay-setting" role="tabpanel" aria-labelledby="home-tab4">
    <div class="card shadow-none">
        <div class="card-body p-0">
            <form action="{{ route('admin.razorpay-setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Razorpay Status</label>
                            <select name="razorpay_status" id="" class="select3 form-control">
                                <option @selected(@$paymentGateway['razorpay_status'] == 1) value="1">Active</option>
                                <option @selected(@$paymentGateway['razorpay_status'] == 0) value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Razorpay Country Name</label>
                            <select name="razorpay_country" id="" class="select3 form-control">
                                <option value="">Select</option>
                                @foreach (config('country_list') as $key => $country)
                                    <option @selected(@$paymentGateway['razorpay_country'] === $key) value="{{ $key }}">{{ $country }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Razorpay Currency</label>
                            <select name="razorpay_currency" id="" class="select3 form-control">
                                <option value="">Select</option>
                                @foreach (config('currencys.currency_list') as $currency)
                                    <option @selected(@$paymentGateway['razorpay_currency'] === $currency) value="{{ $currency }}">{{ $currency }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Currency Rate ( Per {{ config('settings.site_default_currency') }}
                                )</label>
                            <input name="razorpay_rate" type="text" class="form-control"
                                value="{{ @$paymentGateway['razorpay_rate'] }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Razorpay Key</label>
                            <input name="razorpay_api_key" type="text" class="form-control"
                                value="{{ @$paymentGateway['razorpay_api_key'] }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Razorpay Secret Key</label>
                            <input name="razorpay_secret_key" type="text" class="form-control"
                                value="{{ @$paymentGateway['razorpay_secret_key'] }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Razorpay Logo</label>
                    <div id="image-preview-3" class="image-preview razorpay-preview">
                        <label for="image-upload-3" id="image-label-3">
                            <i class="fas fa-camera"></i>
                        </label>
                        <input type="file" name="razorpay_logo" id="image-upload-3" accept="image/*" />
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        var defaultImage = "{{ asset('uploads/default-avatar.jpg') }}";
        var razorpayLogo = "{{ @$paymentGateway['razorpay_logo'] }}";

        var imageToShow = razorpayLogo ? razorpayLogo : defaultImage;

        $('.razorpay-preview').css({
            'background-image': 'url("' + imageToShow + '")',
            'background-size': 'contain',
            'background-position': 'center center',
            'background-repeat': 'no-repeat'
        });

        if (jQuery().select2) {
            $(".select3").select2();
        }

        $.uploadPreview({
            input_field: "#image-upload-3",
            preview_box: "#image-preview-3",
            label_field: "#image-label-3",
            label_default: '<i class="fas fa-camera"></i>',
            label_selected: '<i class="fas fa-camera"></i>',
            no_label: false,
            success_callback: null
        });
    });
</script>
@endpush
