<div class="tab-pane fade show active" id="general-setting" role="tabpanel" aria-labelledby="home-tab4">
    <div class="card shadow-none">
        <div class="card-body p-0">
            <form action="{{ route('admin.general-setting.update') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Site Name</label>
                    <input name="site_name" type="text" class="form-control"
                        value="{{ config('settings.site_name') }}">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Site Email</label>
                            <input name="site_email" type="email" class="form-control"
                                value="{{ config('settings.site_email') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Site Phone</label>
                            <input name="site_phone" type="text" class="form-control"
                                value="{{ config('settings.site_phone') }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Site Address</label>
                    <textarea name="site_address" class="form-control" rows="3">{{ config('settings.site_address') }}</textarea>
                </div>

                <div class="form-group">
                    <label>Default Currency</label>
                    <select name="site_default_currency" class="form-control">
                        <option value="">Select</option>
                        @foreach (config('currencys.currency_list') as $currency)
                            <option @selected(config('settings.site_default_currency') === $currency) value="{{ $currency }}">
                                {{ $currency }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Currency Icon</label>
                            <input name="site_currency_icon" type="text" class="form-control"
                                value="{{ config('settings.site_currency_icon') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Currency Icon Position</label>
                            <select name="site_currency_icon_position" class="form-control">
                                <option @selected(config('settings.site_currency_icon_position') === 'right') value="right">Right</option>
                                <option @selected(config('settings.site_currency_icon_position') === 'left') value="left">Left</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
