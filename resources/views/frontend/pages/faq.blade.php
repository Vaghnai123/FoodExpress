@extends('frontend.layouts.master')

@section('content')
    <section class="fp__breadcrumb" style="background: url({{ config('settings.breadcrumb') }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>frequently asked question</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">home</a></li>
                        <li><a href="javascript:;">FAQs</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="fp__faq" style="margin-top: 40px; margin-bottom: 40px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__faq_area">
                        <div class="accordion" id="accordionExample">
                            @foreach($faqs as $faq)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-{{ $faq->id }}">
                                        <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-{{ $faq->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse-{{ $faq->id }}">
                                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}. {{ $faq->question }}
                                        </button>
                                    </h2>
                                    <div id="collapse-{{ $faq->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading-{{ $faq->id }}"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>{!! $faq->answer !!}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @if($faqs->isEmpty())
                                <p class="text-center">No FAQs available at the moment.</p>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
