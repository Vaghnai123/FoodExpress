@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header shadow-sm"
            style="background-color: #fff; padding: 20px 25px; border-radius: 5px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="margin: 0; font-size: 18px; color: #34395e;">
                <i class="fas fa-question-circle" style="color: #6777ef; margin-right: 10px;"></i> Edit FAQs
            </h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Update FAQ</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.faq.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.faq.update', $faq->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Question</label>
                        <input type="text" name="question" class="form-control" value="{{ $faq->question }}" required>
                    </div>

                    <div class="form-group">
                        <label>Answer</label>
                        <textarea name="answer" class="form-control h-100" rows="5" required>{{ $faq->answer }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ $faq->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $faq->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
@endsection
