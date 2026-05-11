@extends('frontend.layouts.master')


@section('og_metatag_section')
    <meta property="og:title" content="{{ $blog->seo_title }}">
    <meta property="og:description" content="{{ $blog->seo_description }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset($blog->image) }}">
    <meta property="og:site_name" content="{{ config('settings.site_name') }}">
    <meta property="og:type" content="website">
@endsection

@section('content')
    <section class="fp__breadcrumb" style="background: url({{ config('settings.breadcrumb') }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>blog details</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">home</a></li>
                        <li><a href="javascript:;">blog details</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="fp__blog_details" style="margin-top: 40px; margin-bottom: 40px;">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-8">
                    <div class="fp__blog_det_area">
                        <div class="fp__blog_details_img wow fadeInUp" data-wow-duration="1s">
                            <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="imf-fluid w-100">
                        </div>
                        <div class="fp__blog_details_text wow fadeInUp" data-wow-duration="1s">
                            <ul class="details_bloger d-flex flex-wrap">
                                <li><i class="far fa-user"></i> By {{ $blog->user->name }}</li>
                                <li><i class="far fa-comment-alt-lines"></i> {{ count($comments) }} Comments</li>
                                <li><i class="far fa-calendar-alt"></i> {{ date('d-M-Y', strtotime($blog->created_at)) }}
                                </li>
                            </ul>
                            <h2>{!! $blog->title !!}</h2>

                            <div class="summernote-content">
                                {!! $blog->description !!}
                            </div>

                        </div>
                    </div>

                    @if ($nextBlog || $previousBlog)
                        <ul class="blog_det_button mt_100 xs_mt_70 wow fadeInUp" data-wow-duration="1s">
                            @if ($nextBlog)
                                <li>
                                    <a href="{{ route('blogs.details', $nextBlog->slug) }}">
                                        <img src="{{ asset($nextBlog->image) }}" alt="button img" class="img-fluid w-100">
                                        <p>{{ truncate($nextBlog->title) }}
                                            <span> <i class="far fa-long-arrow-left"></i> Previous</span>
                                        </p>
                                    </a>
                                </li>
                            @endif

                            @if ($previousBlog)
                                <li>
                                    <a href="{{ route('blogs.details', $previousBlog->slug) }}">
                                        <p>{{ truncate($previousBlog->title) }}
                                            <span>next <i class="far fa-long-arrow-right"></i></span>
                                        </p>
                                        <img src="{{ asset($previousBlog->image) }}" alt="button img"
                                            class="img-fluid w-100">
                                    </a>
                                </li>
                            @endif
                        </ul>
                    @endif

                    @if (count($comments) > 0)
                        <div class="fp__comment mt_100 xs_mt_70 wow fadeInUp" data-wow-duration="1s">
                            <h3 class="text-capitalize mb-4 pb-3"
                                style="font-weight: 700; color: #2b2b2b; font-size: 20px; border-bottom: 2px solid #d19106;">
                                {{ count($comments) }} Comments
                            </h3>
                            @foreach ($comments as $comment)
                                <div class="fp__single_comment m-0 border-0">
                                    <img src="{{ !empty($comment->user->avatar) ? asset($comment->user->avatar) : asset('default-avatar.jpg') }}"
                                        alt="review" class="img-fluid">
                                    <div class="fp__single_comm_text">
                                        <h3>{{ $comment->user->name }}
                                            <span>{{ date('d-m-Y', strtotime($comment->created_at)) }} </span>
                                        </h3>
                                        <p>{{ $comment->comment }}</p>
                                    </div>
                                </div>
                            @endforeach

                            @if ($comments->hasPages())
                                <div class="fp__pagination mt_60">
                                    <div class="row">
                                        <div class="col-12">
                                            {{ $comments->links() }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="comment_input mt_100 xs_mt_70 wow fadeInUp" data-wow-duration="1s">
                        <h4>Leave A Comment</h4>
                        <p>Required fields are marked *</p>
                        <form action="{{ route('blogs.comment.store', $blog->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12">
                                    <label>comment *</label>
                                    <div class="fp__contact_form_input textarea">
                                        <span><i class="fal fa-user-alt"></i></span>
                                        <textarea rows="5" placeholder="Your Comment" name="comment" required></textarea>
                                    </div>
                                    <button type="submit" class="common_btn mt_20">Submit comment</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4">
                    <div id="sticky_sidebar">
                        <div class="fp__blog_search blog_sidebar m-0 wow fadeInUp" data-wow-duration="1s">
                            <h3>Search</h3>
                            <form action="{{ route('blogs') }}">
                                <input type="text" placeholder="Search" name="search">
                                <button type="submit"><i class="fas fa-search"></i></button>
                            </form>
                        </div>

                        @if ($latestBlogs->count() > 0)
                            <div class="fp__related_blog blog_sidebar wow fadeInUp" data-wow-duration="1s">
                                <h3>Latest Post</h3>
                                <ul>
                                    @foreach ($latestBlogs as $latestBlog)
                                        <li>
                                            <img src="{{ asset($latestBlog->image) }}" alt="{{ $latestBlog->title }}"
                                                class="img-fluid w-100"
                                                style="object-fit: cover; height: 100%; border-radius: 5px;">
                                            <div class="text">
                                                <a
                                                    href="{{ route('blogs.details', $latestBlog->slug) }}">{{ truncate($latestBlog->title, 50) }}</a>
                                                <p><i class="far fa-calendar-alt"></i>
                                                    {{ date('d-m-Y', strtotime($latestBlog->created_at)) }}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if ($categories->count() > 0)
                            <div class="fp__blog_categori blog_sidebar wow fadeInUp" data-wow-duration="1s">
                                <h3>Categories</h3>
                                <ul>
                                    @foreach ($categories as $category)
                                        <li><a href="{{ route('blogs', ['category' => $category->slug]) }}">{{ $category->name }}
                                                <span>{{ $category->blogs_count }}</span></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
