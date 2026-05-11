@extends('frontend.layouts.master')

@section('content')
    <section class="fp__breadcrumb" style="background: url({{ config('settings.breadcrumb') }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>about US</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">home</a></li>
                        <li><a href="javascript:;">about us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>


    <section class="fp__about_us" style="margin-top: 40px; margin-bottom: 40px;">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-5 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__about_us_img">
                        <img src="{{ asset(@$about->image) }}" alt="about us" class="img-fluid w-100">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-7 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__section_heading mb_40">
                        <h4>{!! @$about->title !!}</h4>
                        <h2>{!! @$about->main_title !!}</h2>
                        <span>
                            <img src="images/heading_shapes.png" alt="shapes" class="img-fluid w-100">
                        </span>
                    </div>
                    <div class="fp__about_us_text">
                        {!! @$about->description !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--=============================
                WHY CHOOSE START
            ==============================-->
    @include('frontend.home.components.why-choose')
    <!--=============================
                WHY CHOOSE END
            ==============================-->

    <section class="fp__about_video mt_100 xs_mt_70">
        <div class="container wow fadeInUp" data-wow-duration="1s">
            <div class="fp__about_video_bg" style="background: url({{ getYtThumbnail(@$about->video_link, 'high') }});">
                <div class="fp__about_video_overlay">
                    <div class="row">
                        <div class="col-12">
                            <div class="fp__about_video_text">
                                <p>Watch Videos</p>
                                <a class="play_btn" href="javascript:void(0);" data-bs-toggle="modal"
                                    data-bs-target="#youtubeModal">
                                    <i class=" fas fa-play"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="youtubeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 bg-transparent">
                <div class="modal-header border-0 justify-content-end p-2">
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="ratio ratio-16x9" style="position: relative; padding-bottom: 56.25%; height: 0;">
                        <iframe id="yt-iframe"
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border-radius: 10px;"
                            src="https://www.youtube.com/embed/{{ getYtVideoId(@$about->video_link) }}?autoplay=0&rel=0"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--=============================
                TEAM START
                ==============================-->
    @include('frontend.home.components.team')
    <!--=============================
                TEAM END
                ==============================-->

    <!--=============================
                    COUNTER START
                ==============================-->
    @include('frontend.home.components.counter')
    <!--=============================
                        COUNTER END
                ==============================-->
    <!--=============================
                   TESTIMONIAL  START
                ==============================-->
    @include('frontend.home.components.testimonial')
    <!--=============================
                        TESTIMONIAL END
                ==============================-->
    <!--=============================
                    ABOUT PAGE END
                ==============================-->
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#youtubeModal').on('hidden.bs.modal', function () {
            let $iframe = $(this).find('iframe');
            let tempSrc = $iframe.attr('src');
            $iframe.attr('src', '');
            $iframe.attr('src', tempSrc);
        });
    });
</script>
@endpush
