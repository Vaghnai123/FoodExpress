@extends('admin.layouts.master')

@section('content')
    <section class="section">

        <div class="section-header shadow-sm"
            style="background-color: #fff; padding: 20px 25px; border-radius: 5px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="margin: 0; font-size: 18px; color: #34395e;">
                <i class="fas fa-address-book" style="color: #6777ef; margin-right: 10px;"></i> Contact
            </h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Updated Contact</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.contact.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="">Phone One</label>
                        <input type="text" class="form-control" name="phone_one" value="{{ @$contact->phone_one }}">
                    </div>

                    <div class="form-group">
                        <label for="">Phone Two</label>
                        <input type="text" class="form-control" name="phone_two" value="{{ @$contact->phone_two }}">
                    </div>

                    <div class="form-group">
                        <label for="">Email One</label>
                        <input type="text" class="form-control" name="mail_one" value="{{ @$contact->mail_one }}">
                    </div>

                    <div class="form-group">
                        <label for="">Email Two</label>
                        <input type="text" class="form-control" name="mail_two" value="{{ @$contact->mail_two }}">
                    </div>

                    <div class="form-group">
                        <label for="">Address</label>
                        <input type="text" class="form-control" name="address" value="{{ @$contact->address }}">
                    </div>

                    <div class="form-group">
                        <label for="">Google Map Link</label>
                        <input type="text" class="form-control" name="map_link" value="{{ @$contact->map_link }}">
                        <small class="form-text text-danger pt-2">
                            <b>Note :</b> Please Enter only the Google Maps <strong>Embed URL</strong> here ( found inside the
                            <code>&lt;iframe src="..."&gt;</code> tag ). A direct web browser link will not work.
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
@endsection
