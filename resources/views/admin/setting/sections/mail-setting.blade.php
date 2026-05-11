<div class="tab-pane fade show" id="mail-setting" role="tabpanel" aria-labelledby="home-tab4">
    <div class="card shadow-none">
        <div class="card-body p-0">
            <form action="{{ route('admin.mail-setting.update') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Mail Driver</label>
                    <input name="mail_driver" type="text" class="form-control" value="{{ config('settings.mail_driver') }}">
                </div>

                <div class="form-group">
                    <label>Mail Host</label>
                    <input name="mail_host" type="text" class="form-control" value="{{ config('settings.mail_host') }}">
                </div>

                <div class="form-group">
                    <label>Mail Port</label>
                    <input name="mail_port" type="text" class="form-control" value="{{ config('settings.mail_port') }}">
                </div>

                <div class="form-group">
                    <label>Mail Username</label>
                    <input name="mail_username" type="text" class="form-control" value="{{ config('settings.mail_username') }}">
                </div>

                <div class="form-group">
                    <label>Mail Password</label>
                    <input name="mail_password" type="text" class="form-control" value="{{ config('settings.mail_password') }}">
                </div>

                <div class="form-group">
                    <label>Mail Encryption</label>
                    <input name="mail_encryption" type="text" class="form-control" value="{{ config('settings.mail_encryption') }}">
                </div>

                <div class="form-group">
                    <label>Mail Form Address</label>
                    <input name="mail_from_address" type="text" class="form-control" value="{{ config('settings.mail_from_address') }}">
                </div>

                <div class="form-group">
                    <label>Mail Receive Address</label>
                    <input name="mail_receive_address" type="text" class="form-control" value="{{ config('settings.mail_receive_address') }}">
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
