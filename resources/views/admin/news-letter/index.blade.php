@extends('admin.layouts.master')

@section('content')
    <section class="section">

        <div class="section-header shadow-sm"
            style="background-color: #fff; padding: 20px 25px; border-radius: 5px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="margin: 0; font-size: 18px; color: #34395e;">
                <i class="fas fa-newspaper" style="color: #6777ef; margin-right: 10px;"></i> Subscribers
            </h1>
        </div>

        <div class="card" style="background-color: transparent; border: none; box-shadow: none;">
            <div class="card-body p-0">
                <div id="accordion">
                    <div class="accordion">
                        <div class="accordion-header collapsed bg-primary text-light p-3 shadow-sm" role="button"
                            data-toggle="collapse" data-target="#panel-body-1" aria-expanded="false"
                            style="border-radius: 5px;">
                            <h4>Send News Letter..</h4>
                        </div>
                        <div class="accordion-body collapse p-0 mt-3" id="panel-body-1" data-parent="#accordion">
                            <form action="{{ route('admin.news-letter.send') }}" method="POST">
                                @csrf
                                <div class="form-group mb-4">
                                    <label for="" class="font-weight-bold">Subject</label>
                                    <input type="text" class="form-control form-control-lg" name="subject" value=""
                                        style="background-color: #fff; border: 1px solid #ced4da; border-radius: 5px;">
                                </div>

                                <div class="form-group mb-4">
                                    <label for="" class="font-weight-bold">Message</label>
                                    <textarea name="message" class="summernote"></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg shadow-sm">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <section class="section">
        <div class="card card-primary">
            <div class="card-header">
                <h4>All Subscribers</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
