@extends('admin.layouts.master')

@push('styles')
    <style>
        .simple-invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .simple-invoice-header .invoice-heading {
            margin: 0;
            font-size: 1.5rem;
            color: #34395e;
            font-weight: 700;
        }

        .simple-invoice-header .invoice-number {
            font-size: 1.0rem;
            color: #6c757d;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .simple-invoice-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }

        .invoice-address {
            line-height: 2;
            margin: 0 !important;
            padding: 0;
        }
    </style>
@endpush

@section('content')
    <section class="section">

        <div class="section-header shadow-sm"
            style="background-color: #fff; padding: 20px 25px; border-radius: 5px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="margin: 0; font-size: 18px; color: #34395e;">
                <i class="fas fa-shopping-bag" style="color: #6777ef; margin-right: 10px;"></i> Order Preview
            </h1>
        </div>

        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="simple-invoice-header">
                                <h2 class="invoice-heading">Food Express</h2>
                                <div class="invoice-number">Order #{{ $order->invoice_id }}</div>
                            </div>
                            <hr>

                            <div class="row mb-4">
                                <div class="col-md-6 mb-2 mb-md-0">
                                    <address class="invoice-address">
                                        <strong>Deliver To :</strong><br>
                                        <strong>Name :</strong> {!! @$order->userAddress->first_name !!} {!! @$order->userAddress->last_name !!}
                                        <br>
                                        <strong>Phone :</strong> {!! @$order->userAddress->phone !!}
                                        <br>
                                        <strong>Address :</strong> {!! @$order->userAddress->address !!}
                                        <br>
                                        <strong>Aria :</strong> {!! @$order->userAddress->deliveryArea->area_name !!}
                                    </address>
                                </div>

                                <div class="col-md-6 text-md-right">
                                    <address class="invoice-address ">
                                        <strong>Order Date :</strong>
                                        {{ date('F d, Y / H:i', strtotime($order->created_at)) }}
                                    </address>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2 mb-md-0">
                                    <address class="invoice-address">
                                        <strong>Payment Method :</strong> {{ $order->payment_method }}<br>
                                        <strong>Payment Status : </strong>
                                        @if (strtoupper($order->payment_status) == 'COMPLETED')
                                            <span class="badge badge-success">COMPLETED</span>
                                        @elseif(strtoupper($order->payment_status) == 'PENDING')
                                            <span class="badge badge-warning">PENDING</span>
                                        @else
                                            <span class="badge badge-danger">{{ $order->payment_status }}</span>
                                        @endif
                                        <br>
                                        <strong>Transaction ID :</strong> {{ $order->transaction_id ?? 'N/A' }}
                                    </address>
                                </div>

                                <div class="col-md-6 text-md-right">
                                    <address class="invoice-address">
                                        <strong>Order Status :</strong>
                                        @if ($order->order_status === 'delivered')
                                            <span class="badge badge-success">Delivered</span>
                                        @elseif($order->order_status === 'declined')
                                            <span class="badge badge-danger">Declined</span>
                                        @else
                                            <span class="badge badge-warning">{{ $order->order_status }}</span>
                                        @endif
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">Order Summary</div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th data-width="40">#</th>
                                        <th>Item</th>
                                        <th>Size & Optional</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-right">Totals</th>
                                    </tr>
                                    @foreach ($order->orderItems as $orderItem)
                                        @php
                                            $size = json_decode($orderItem->product_size);
                                            $options = json_decode($orderItem->product_option);

                                            $qty = $orderItem->qty;
                                            $untiPrice = $orderItem->unit_price;

                                            $sizePrice = is_object($size) && isset($size->price) ? $size->price : 0;

                                            $optionPrice = 0;
                                            if (is_array($options) || is_object($options)) {
                                                foreach ($options as $optionItem) {
                                                    if (is_object($optionItem) && isset($optionItem->price)) {
                                                        $optionPrice += $optionItem->price;
                                                    }
                                                }
                                            }

                                            $productTotal = ($untiPrice + $sizePrice + $optionPrice) * $qty;
                                        @endphp
                                        <tr>
                                            <td>{{ ++$loop->index }}</td>
                                            <td>{{ $orderItem->product_name }}</td>
                                            <td>
                                                @if (is_object($size) && isset($size->name))
                                                    <b>{{ $size->name }} ({{ currencyPosition($size->price) }})</b>
                                                    <br>
                                                @endif

                                                @if (is_array($options) && count($options) > 0)
                                                    @foreach ($options as $option)
                                                        @if (is_object($option))
                                                            {{ $option->name }} ({{ currencyPosition($option->price) }})
                                                            <br>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </td>

                                            <td class="text-center">{{ currencyPosition($orderItem->unit_price) }}</td>
                                            <td class="text-center">{{ $orderItem->qty }}</td>
                                            <td class="text-right">{{ currencyPosition($productTotal) }}</td>
                                        </tr>
                                    @endforeach

                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-8">
                                    <div class="col-md-4 d-print-none">
                                        <form action="{{ route('admin.orders.status-update', $order->id) }}"
                                            method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="">Payment Status</label>
                                                <select class="form-control" name="payment_status" id="">
                                                    <option @selected($order->payment_status === 'pending') value="pending">Pending</option>
                                                    <option @selected($order->payment_status === 'completed') value="completed">Completed
                                                    </option>
                                                </select>

                                            </div>

                                            <div class="form-group">
                                                <label for="">Order Status</label>
                                                <select class="form-control" name="order_status" id="">
                                                    <option @selected($order->order_status === 'pending') value="pending">Pending</option>
                                                    <option @selected($order->order_status === 'in_process') value="in_process">In Process
                                                    </option>
                                                    <option @selected($order->order_status === 'delivered') value="delivered">Delivered
                                                    </option>
                                                    <option @selected($order->order_status === 'declined') value="declined">Declined</option>

                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-info">Update</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Subtotal</div>
                                        <div class="invoice-detail-value">{{ currencyPosition($order->subtotal) }}</div>
                                    </div>
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Shipping</div>
                                        <div class="invoice-detail-value">{{ currencyPosition($order->delivery_charge) }}
                                        </div>
                                    </div>
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Discount</div>
                                        <div class="invoice-detail-value">{{ currencyPosition($order->discount) }}</div>
                                    </div>
                                    <hr class="mt-2 mb-2">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Total</div>
                                        <div class="invoice-detail-value invoice-detail-value-lg">
                                            {{ currencyPosition($order->grand_total) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-md-right">
                    <div class="float-lg-left mb-lg-0 mb-3">

                    </div>
                    <a href="{{ route('admin.orders.download-invoice', $order->id) }}"
                        class="btn btn-primary btn-icon icon-left">
                        <i class="fas fa-download"></i> Download PDF
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
