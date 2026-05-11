@extends('admin.layouts.master')

@push('styles')
    <style>
        .select2-container .select2-selection--single {
            height: 42px !important;
            border-color: #e4e6fc;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            line-height: 42px !important;
            padding-left: 15px;
        }

        .select2-container .select2-selection--single .select2-selection__arrow {
            height: 42px !important;
        }
    </style>
    <style>
        /* Custom Round Image Upload Preview for all gateways */
        .paypal-preview,
        .razorpay-preview,
        .stripe-preview {
            width: 150px !important;
            height: 150px !important;
            border-radius: 50% !important;
            border: 2px dashed #6777ef;
            overflow: hidden;
            position: relative;
            margin-top: 10px;
        }

        .paypal-preview label,
        .razorpay-preview label,
        .stripe-preview label {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            opacity: 0;
            cursor: pointer;
            z-index: 10;
            margin: 0;
        }

        .paypal-preview:hover label,
        .razorpay-preview:hover label,
        .stripe-preview:hover label {
            opacity: 1;
        }

        .paypal-preview label i,
        .razorpay-preview label i,
        .stripe-preview label i {
            font-size: 32px;
            color: #ffffff;
        }

        .paypal-preview input[type="file"],
        .razorpay-preview input[type="file"],
        .stripe-preview input[type="file"] {
            display: none;
        }
    </style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header shadow-sm"
            style="background-color: #fff; padding: 20px 25px; border-radius: 5px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="margin: 0; font-size: 18px; color: #34395e;">
                <i class="fas fa-credit-card" style="color: #6777ef; margin-right: 10px;"></i> Payment Gateway
            </h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>All Gateways</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-3">
                        <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                            <li class="nav-item mb-2">
                                <a class="nav-link active" id="home-tab4" data-toggle="tab" href="#paypal-setting"
                                    role="tab" aria-controls="home" aria-selected="true">Paypal</a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#stripe-setting"
                                    role="tab" aria-controls="profile" aria-selected="false">Stripe</a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#razorpay-setting"
                                    role="tab" aria-controls="contact" aria-selected="false">Razorpay</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-sm-12 col-md-9">
                        <div class="tab-content no-padding" id="myTab2Content">
                            @include('admin.payment-setting.sections.paypal')

                            @include('admin.payment-setting.sections.stripe')

                            @include('admin.payment-setting.sections.razorpay')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
