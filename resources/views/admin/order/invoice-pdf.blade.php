<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->invoice_id }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            color: #333;
            font-size: 14px;
            line-height: 1.5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        /* Header section */
        .company-name {
            font-size: 26px;
            color: #6777ef;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .invoice-title {
            font-size: 34px;
            color: #e9ecef;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0 0 15px 0;
        }

        /* Invoice Details Table (Right Side) */
        .invoice-details-table td {
            padding: 4px 8px;
            border: none;
            font-size: 13px;
        }

        .invoice-details-table .label {
            font-weight: bold;
            text-align: right;
            width: 60%;
        }

        .invoice-details-table .value {
            text-align: right;
            width: 40%;
        }

        /* Divider */
        .divider {
            border-bottom: 2px solid #6777ef;
            margin: 25px 0;
        }

        /* Address Section */
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #6777ef;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        /* Items Table */
        .items-table {
            margin-top: 30px;
            border: 1px solid #ddd;
        }

        .items-table th {
            background-color: #f8f9fa;
            padding: 12px 10px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
            border-bottom: 2px solid #ddd;
        }

        .items-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
        }

        /* Summary Table */
        .summary-table td {
            padding: 10px;
            border: none;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        .summary-table .label {
            font-weight: bold;
            text-align: left;
        }

        .summary-table .value {
            text-align: right;
        }

        .grand-total {
            font-size: 18px;
            font-weight: bold;
            color: #6777ef;
        }

        .grand-total-border {
            border-bottom: 2px solid #6777ef !important;
        }

        .footer {
            margin-top: 60px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>

<body>

    <table style="border: none;">
        <tr>
            <td class="text-left" style="width: 50%; vertical-align: top; border: none;">
                <div class="company-name">{{ config('settings.site_name') }}</div>
                <div>{!! nl2br(e(config('settings.site_address'))) !!}</div>
                <div style="margin-top: 5px;"><strong>Phone :</strong> {{ config('settings.site_phone') }}</div>
                <div><strong>Email :</strong> {{ config('settings.site_email') }}</div>
            </td>

            <td class="text-right" style="width: 50%; vertical-align: top; border: none;">
                <div class="invoice-title">INVOICE</div>
                <table class="invoice-details-table" align="right" style="width: 80%;">
                    <tr>
                        <td class="label">Invoice No :</td>
                        <td class="value">#{{ $order->invoice_id }}</td>
                    </tr>
                    <tr>
                        <td class="label">Order Date :</td>
                        <td class="value">{{ date('d M, Y ', strtotime($order->created_at)) }}</td>
                    </tr>
                    <tr>
                        <td class="label">Payment Method :</td>
                        <td class="value">{{ strtoupper($order->payment_method) }}</td>
                    </tr>
                    <tr>
                        <td class="label">Payment Status :</td>
                        <td class="value">{{ strtoupper($order->payment_status) }}</td>
                    </tr>
                    <tr>
                        <td class="label">Transaction ID :</td>
                        <td class="value">{{ $order->transaction_id ?? 'N/A' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    <table style="border: none;">
        <tr>
            <td style="width: 50%; vertical-align: top; border: none;">
                <div class="section-title">Billed & Delivered To :</div>

                <div class="font-bold" style="font-size: 16px; margin-bottom: 8px;">
                    {{ @$order->userAddress->first_name }} {{ @$order->userAddress->last_name }}
                </div>

                <div style="margin-bottom: 8px;">
                    <strong>Address :</strong> {{ @$order->userAddress->address }}
                </div>

                <div style="margin-bottom: 8px;">
                    <strong>Area :</strong> {{ @$order->userAddress->deliveryArea->area_name }}
                </div>

                <div style="margin-bottom: 8px;">
                    <strong>Phone :</strong> {{ @$order->userAddress->phone }}
                </div>
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">#</th>
                <th class="text-left" style="width: 45%;">Item Description</th>
                <th class="text-center" style="width: 15%;">Unit Price</th>
                <th class="text-center" style="width: 15%;">Qty</th>
                <th class="text-right" style="width: 20%;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $orderItem)
                @php
                    $size = json_decode($orderItem->product_size);
                    $options = json_decode($orderItem->product_option);

                    $sizePrice = is_object($size) && isset($size->price) ? $size->price : 0;
                    $optionPrice = 0;
                    if (is_array($options) || is_object($options)) {
                        foreach ($options as $optionItem) {
                            if (is_object($optionItem) && isset($optionItem->price)) {
                                $optionPrice += $optionItem->price;
                            }
                        }
                    }
                    $productTotal = ($orderItem->unit_price + $sizePrice + $optionPrice) * $orderItem->qty;
                @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-left">
                        <div class="font-bold" style="font-size: 15px; color: #333; margin-bottom: 5px;">
                            {{ $orderItem->product_name }}
                        </div>

                        @if (is_object($size) && isset($size->name))
                            <div style="font-size: 12px; color: #666; margin-top: 4px;">
                                <strong style="color: #333;">Size :</strong> {{ $size->name }} <span
                                    style="color: #888;">(+{{ currencyPosition($size->price) }})</span>
                            </div>
                        @endif

                        @if (is_array($options) && count($options) > 0)
                            <div style="font-size: 12px; color: #666; margin-top: 4px;">
                                <strong style="color: #333;">Options :</strong>
                                @foreach ($options as $option)
                                    @if (is_object($option))
                                        {{ $option->name }} <span
                                            style="color: #888;">(+{{ currencyPosition($option->price) }})</span>{{ !$loop->last ? ', ' : '' }}
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </td>
                    <td class="text-center">{{ currencyPosition($orderItem->unit_price) }}</td>
                    <td class="text-center">{{ $orderItem->qty }}</td>
                    <td class="text-right">{{ currencyPosition($productTotal) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table style="border: none; margin-top: 20px;">
        <tr>
            <td style="width: 55%; border: none;"></td>
            <td style="width: 45%; border: none; padding: 0;">
                <table class="summary-table">
                    <tr>
                        <td class="label">Subtotal :</td>
                        <td class="value">{{ currencyPosition($order->subtotal) }}</td>
                    </tr>
                    <tr>
                        <td class="label">Shipping Charge :</td>
                        <td class="value">{{ currencyPosition($order->delivery_charge) }}</td>
                    </tr>
                    <tr>
                        <td class="label">Discount :</td>
                        <td class="value" style="color: #e74c3c;">- {{ currencyPosition($order->discount) }}</td>
                    </tr>
                    <tr>
                        <td class="label grand-total grand-total-border">Grand Total :</td>
                        <td class="value grand-total grand-total-border">{{ currencyPosition($order->grand_total) }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div style="margin-top: 40px;">
        <div class="font-bold" style="font-size: 13px; margin-bottom: 5px;">Terms & Conditions :-</div>
        <ul style="font-size: 11px; color: #666; padding-left: 15px; margin: 0; line-height: 1.6;">
            <li>All items are non-refundable once delivered and accepted.</li>
            <li>If you have any questions concerning this invoice, please contact our support team.</li>
        </ul>
    </div>

    <div class="footer">
        <strong>Thank you for your order!</strong><br>
        Food Express | www.Foodexpress.com
    </div>

</body>

</html>
