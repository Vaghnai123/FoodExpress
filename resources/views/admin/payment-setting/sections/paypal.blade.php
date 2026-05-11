<div class="tab-pane fade show active" id="paypal-setting" role="tabpanel" aria-labelledby="home-tab4">
    <div class="card shadow-none">
        <div class="card-body p-0">
            <form action="{{ route('admin.paypal-setting.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Paypal Status</label>
                            <select name="paypal_status" id="" class="select2 form-control">
                                <option @selected(@$paymentGateway['paypal_status'] == 1) value="1">Active</option>
                                <option @selected(@$paymentGateway['paypal_status'] == 0) value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Paypal Account Mode</label>
                            <select name="paypal_account_mode" id="" class="select2 form-control">
                                <option @selected(@$paymentGateway['paypal_account_mode'] === 'sandbox') value="sandbox">Sandbox</option>
                                <option @selected(@$paymentGateway['paypal_account_mode'] === 'live') value="live">Live</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Paypal Country Name</label>
                            <select name="paypal_country" id="" class="select2 form-control">
                                <option value="">Select</option>
                                @foreach (config('country_list') as $key => $country)
                                    <option @selected(@$paymentGateway['paypal_country'] === $key) value="{{ $key }}">{{ $country }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Paypal Currency Name</label>
                            <select name="paypal_currency" id="" class="select2 form-control">
                                <option value="">Select</option>
                                @foreach (config('currencys.currency_list') as $currency)
                                    <option @selected(@$paymentGateway['paypal_currency'] === $currency) value="{{ $currency }}">{{ $currency }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Currency Rate ( Per {{ config('settings.site_default_currency') }}
                                )</label>
                            <input name="paypal_rate" type="text" class="form-control"
                                value="{{ @$paymentGateway['paypal_rate'] }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Paypal App Id</label>
                            <input name="paypal_app_id" type="text" class="form-control"
                                value="{{ @$paymentGateway['paypal_app_id'] }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Paypal Client Id</label>
                            <input name="paypal_api_key" type="text" class="form-control"
                                value="{{ @$paymentGateway['paypal_api_key'] }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Paypal Secret Key</label>
                            <input name="paypal_secret_key" type="text" class="form-control"
                                value="{{ @$paymentGateway['paypal_secret_key'] }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Paypal Logo</label>
                    <div id="image-preview" class="image-preview paypal-preview">
                        <label for="image-upload" id="image-label">
                            <i class="fas fa-camera"></i>
                        </label>
                        <input type="file" name="paypal_logo" id="image-upload" accept="image/*" />
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
        var paypalLogo = "{{ @$paymentGateway['paypal_logo'] }}";
        
        var imageToShow = paypalLogo ? paypalLogo : defaultImage;

        $('.paypal-preview').css({
            'background-image': 'url("' + imageToShow + '")',
            'background-size': 'contain',
            'background-position': 'center center',
            'background-repeat': 'no-repeat'
        });
    });
</script>
@endpush
