<div class="tab-pane fade show" id="stripe-setting" role="tabpanel" aria-labelledby="home-tab4">
    <div class="card shadow-none">
        <div class="card-body p-0">
            <form action="{{ route('admin.stripe-setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Stripe Status</label>
                            <select name="stripe_status" id="" class="select3 form-control">
                                <option @selected(@$paymentGateway['stripe_status'] == 1) value="1">Active</option>
                                <option @selected(@$paymentGateway['stripe_status'] == 0) value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Stripe Country Name</label>
                            <select name="stripe_country" id="" class="select3 form-control">
                                <option value="">Select</option>
                                @foreach (config('country_list') as $key => $country)
                                    <option @selected(@$paymentGateway['stripe_country'] === $key) value="{{ $key }}">{{ $country }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Stripe Currency</label>
                            <select name="stripe_currency" id="" class="select3 form-control">
                                <option value="">Select</option>
                                @foreach (config('currencys.currency_list') as $currency)
                                    <option @selected(@$paymentGateway['stripe_currency'] === $currency) value="{{ $currency }}">{{ $currency }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Currency Rate ( Per {{ config('settings.site_default_currency') }}
                                )</label>
                            <input name="stripe_rate" type="text" class="form-control"
                                value="{{ @$paymentGateway['stripe_rate'] }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Stripe Key</label>
                            <input name="stripe_api_key" type="text" class="form-control"
                                value="{{ @$paymentGateway['stripe_api_key'] }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Stripe Secret Key</label>
                            <input name="stripe_secret_key" type="text" class="form-control"
                                value="{{ @$paymentGateway['stripe_secret_key'] }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Stripe Logo</label>
                    <div id="image-preview-2" class="image-preview stripe-preview">
                        <label for="image-upload-2" id="image-label-2">
                            <i class="fas fa-camera"></i>
                        </label>
                        <input type="file" name="stripe_logo" id="image-upload-2" accept="image/*" />
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
        var defaultImage = "{{ asset('default-avatar.jpg') }}";
        var stripeLogo = "{{ @$paymentGateway['stripe_logo'] }}";

        var imageToShow = stripeLogo ? stripeLogo : defaultImage;

        $('.stripe-preview').css({
            'background-image': 'url("' + imageToShow + '")',
            'background-size': 'contain',
            'background-position': 'center center',
            'background-repeat': 'no-repeat'
        });

        if (jQuery().select2) {
            $(".select3").select2();
        }

        $.uploadPreview({
            input_field: "#image-upload-2",
            preview_box: "#image-preview-2",
            label_field: "#image-label-2",
            label_default: '<i class="fas fa-camera"></i>',
            label_selected: '<i class="fas fa-camera"></i>',
            no_label: false,
            success_callback: null
        });
    });
</script>
@endpush
