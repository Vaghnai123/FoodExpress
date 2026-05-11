@extends('frontend.layouts.master')

@section('content')
    <section class="fp__breadcrumb" style="background: url({{ asset('frontend/images/counter_bg.jpg') }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>verify email</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">home</a></li>
                        <li><a href="javascript:;">verify email</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="fp__signin" style="background: url({{ asset('frontend/images/login_bg.jpg') }});">
        <div class="fp__signin_overlay pt_125 xs_pt_95 pb_100 xs_pb_70">
            <div class="container">
                <div class="row wow fadeInUp" data-wow-duration="1s">
                    <div class="col-xxl-5 col-xl-6 col-md-9 col-lg-7 m-auto">
                        <div class="fp__login_area">
                            <h2>Verify Your Email</h2>

                            <p style="text-transform: none; line-height: 24px; margin-bottom: 20px;">
                                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                            </p>

                            @if (session('status') == 'verification-link-sent')
                                <div class="alert alert-success" style="font-size: 14px; margin-bottom: 25px;">
                                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="fp__login_imput">
                                            <button type="submit" class="common_btn">Resend Verification Email</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                                @csrf
                                <p class="create_account d-flex justify-content-center">
                                    <button type="submit"
                                        style="background: transparent; border: none; font-weight: 500; font-size: 16px; text-transform: capitalize; color: #ff7c08; transition: all auto .3s; cursor: pointer;">
                                        {{ __('Log Out') }}
                                    </button>
                                </p>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
