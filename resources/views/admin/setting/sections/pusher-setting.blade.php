<div class="tab-pane fade show" id="pusher-setting" role="tabpanel" aria-labelledby="pusher-tab4">
    <div class="card shadow-none">
        <div class="card-body p-0">
            <form action="{{ route('admin.pusher-setting.update') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Pusher App Id</label>
                    <input name="pusher_app_id" type="text" class="form-control" value="{{ config('settings.pusher_app_id') }}">
                </div>

                <div class="form-group">
                    <label>Pusher Key</label>
                    <input name="pusher_key" type="text" class="form-control" value="{{ config('settings.pusher_key') }}">
                </div>

                <div class="form-group">
                    <label>Pusher Secret</label>
                    <input name="pusher_secret" type="text" class="form-control" value="{{ config('settings.pusher_secret') }}">
                </div>

                <div class="form-group">
                    <label>Pusher Cluster</label>
                    <input name="pusher_cluster" type="text" class="form-control" value="{{ config('settings.pusher_cluster') }}">
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
