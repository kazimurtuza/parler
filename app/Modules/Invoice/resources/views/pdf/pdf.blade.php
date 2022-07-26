<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>

    <style>
        :root {
            --primary: #522E91;
            --secondary: #273981;
            --primary-hover: var(--secondary);
            --primary-light: #d8ddf3;
            --primary-light-1: #9977d4;
            --primary-dark: #1d2b62;
            --rgba-primary-1: rgba(82, 46, 145, 0.1);
            --rgba-primary-2: rgba(82, 46, 145, 0.2);
            --rgba-primary-3: rgba(82, 46, 145, 0.3);
            --rgba-primary-4: rgba(82, 46, 145, 0.4);
            --rgba-primary-5: rgba(82, 46, 145, 0.5);
            --rgba-primary-6: rgba(82, 46, 145, 0.6);
            --rgba-primary-7: rgba(82, 46, 145, 0.7);
            --rgba-primary-8: rgba(82, 46, 145, 0.8);
            --rgba-primary-9: rgba(82, 46, 145, 0.9);
            --primary-gradient-1: linear-gradient(90deg, #273981 0%, #522E91 100%);
            --primary-gradient-1-hover: linear-gradient(90deg, #522E91 0%, #273981 100%);
            --secondary-gradient-1: linear-gradient(30deg, #1a1a1a 0%, #9a9a9a 100%);
            --secondary-gradient-1-hover: linear-gradient(30deg, #9a9a9a 0%, #1a1a1a 100%);
            --font-family-base: Roboto, sans-serif;
            --font-family-title: Roboto, sans-serif;
            --title: #000;
        }

        @font-face {
            font-family: 'Kalpurush';
            src: url("{!! asset('assets/fonts/Kalpurush/Kalpurush.woff') !!}");
            font-weight: normal;
            font-style: normal;
        }

        /* poppins-100 - latin */
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 100;
            src: url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-100.eot') }}'); /* IE9 Compat Modes */
            src: local(''),
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-100.eot?#iefix') }}') format('embedded-opentype'), /* IE6-IE8 */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-100.woff2') }}') format('woff2'), /* Super Modern Browsers */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-100.woff') }}') format('woff'), /* Modern Browsers */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-100.ttf') }}') format('truetype'), /* Safari, Android, iOS */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-100.svg#Poppins') }}') format('svg'); /* Legacy iOS */
        }
        /* poppins-200 - latin */
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 200;
            src: url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-200.eot') }}'); /* IE9 Compat Modes */
            src: local(''),
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-200.eot?#iefix') }}') format('embedded-opentype'), /* IE6-IE8 */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-200.woff2') }}') format('woff2'), /* Super Modern Browsers */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-200.woff') }}') format('woff'), /* Modern Browsers */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-200.ttf') }}') format('truetype'), /* Safari, Android, iOS */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-200.svg#Poppins') }}') format('svg'); /* Legacy iOS */
        }
        /* poppins-300 - latin */
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 300;
            src: url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-300.eot') }}'); /* IE9 Compat Modes */
            src: local(''),
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-300.eot?#iefix') }}') format('embedded-opentype'), /* IE6-IE8 */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-300.woff2') }}') format('woff2'), /* Super Modern Browsers */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-300.woff') }}') format('woff'), /* Modern Browsers */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-300.ttf') }}') format('truetype'), /* Safari, Android, iOS */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-300.svg#Poppins') }}') format('svg'); /* Legacy iOS */
        }
        /* poppins-300italic - latin */
        @font-face {
            font-family: 'Poppins';
            font-style: italic;
            font-weight: 300;
            src: url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-300italic.eot') }}'); /* IE9 Compat Modes */
            src: local(''),
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-300italic.eot?#iefix') }}') format('embedded-opentype'), /* IE6-IE8 */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-300italic.woff2') }}') format('woff2'), /* Super Modern Browsers */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-300italic.woff') }}') format('woff'), /* Modern Browsers */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-300italic.ttf') }}') format('truetype'), /* Safari, Android, iOS */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-300italic.svg#Poppins') }}') format('svg'); /* Legacy iOS */
        }
        /* poppins-regular - latin */
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            src: url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-regular.eot') }}'); /* IE9 Compat Modes */
            src: local(''),
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-regular.eot?#iefix') }}') format('embedded-opentype'), /* IE6-IE8 */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-regular.woff2') }}') format('woff2'), /* Super Modern Browsers */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-regular.woff') }}') format('woff'), /* Modern Browsers */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-regular.ttf') }}') format('truetype'), /* Safari, Android, iOS */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-regular.svg#Poppins') }}') format('svg'); /* Legacy iOS */
        }
        /* poppins-500 - latin */
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 500;
            src: url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-500.eot') }}'); /* IE9 Compat Modes */
            src: local(''),
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-500.eot?#iefix') }}') format('embedded-opentype'), /* IE6-IE8 */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-500.woff2') }}') format('woff2'), /* Super Modern Browsers */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-500.woff') }}') format('woff'), /* Modern Browsers */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-500.ttf') }}') format('truetype'), /* Safari, Android, iOS */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-500.svg#Poppins') }}') format('svg'); /* Legacy iOS */
        }
        /* poppins-600 - latin */
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 600;
            src: url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-600.eot') }}'); /* IE9 Compat Modes */
            src: local(''),
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-600.eot?#iefix') }}') format('embedded-opentype'), /* IE6-IE8 */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-600.woff2') }}') format('woff2'), /* Super Modern Browsers */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-600.woff') }}') format('woff'), /* Modern Browsers */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-600.ttf') }}') format('truetype'), /* Safari, Android, iOS */
            url('{{ asset('assets/fonts/Poppins/poppins-v20-latin-600.svg#Poppins') }}') format('svg'); /* Legacy iOS */
        }

        /*.currency-text {
            font-family: 'Kalpurush', sans-serif !important;
            font-size: 16px;
        }*/
        *,body,h1,h2,h3,h4,h5,h6,p,span,div,b,strong,table,thead,tbody,tfoot,tr,th,td,label,button {
            font-family: 'Poppins', sans-serif !important;
        }

        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .text-left {
            text-align: left;
        }
        th {
            text-align: center;
        }

        .table {
            width: 100%;
        }

        body {
            padding: 20px 15px;
            width: 95%;
            margin: 0 auto;
        }

        .table {
            width: 100%;
        }

        .center_col {
            text-align: center;
        }

        .right_col {
            text-align: right;
        }

        .left_col {
            text-align: left;
        }

        .balance_col {
            text-align: right;
        }

        .page-break {
            page-break-after: always;
        }

        .company-details {
            /*border: 1px solid #000000;*/
            padding: 5px 20px;
        }


        .invoice-details-wrapper h3, .invoice-details-wrapper p {
            display: inline-block;
            margin: 3px;
        }


        .table {
            /*margin: 0 auto;*/
            /*width: 95%;*/
            font-size: 12px;
        }
        .table th{
            text-align: center;
        }

        .table th, .table td {
            /*border: 1px solid black;*/
            font-weight: normal;
            padding: 10px 3px;
        }

        .text-bold {
            font-weight: bold;
        }

        .header_left {
            float: left;
        }
        .header_left img {
            max-width: 150px;
        }
        .header_right {
            /*float: left;*/
            text-align: right;
            /*margin-right: 120px;*/
        }
        .header_wrapper {
            display: block;
            height: 100px;
        }

        .row {
            width: 100%;
            padding: 10px;
        }
        .col-sm-6 {
            width: 50%;
            float: left;
            display: block;
        }
        .col-sm-12 {
            width: 100%;
            display: block;
        }

        .table-bordered {
            /*border: 1px solid #ddd;*/
        }
        .table-bordered td{
            border-bottom: 1px solid #ddd;
            /*border-right: 1px solid #ddd;*/
        }
        .last-no-bordered tr:last-child td{
            border-bottom: 0px solid #ddd;
        }
        .table-bordered th{
            border-bottom: 1px solid #ddd;
        }

        .float-right {
            float: right !important;
        }
        .list-unstyled {
            list-style: none;
        }
        .w-95prc {
            width: 95%;
            margin: 0 auto;
        }
        .text-justify {
            text-align: justify;
        }
        h1,h2,h3,h4 {
            margin: 0;
            padding: 0;
        }
        .small-img {
            max-width: 40px;

            margin-right: 10px;
            -webkit-border-radius: 20px;
            -moz-border-radius: 20px;
            border-radius: 20px;
        }
        .row {
            display: -webkit-box; /* wkhtmltopdf uses this one */
            display: flex;
            -webkit-box-pack: center; /* wkhtmltopdf uses this one */
            justify-content: center;
        }

        .row > div {
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            flex: 1;
        }

        .row > div:last-child {
            margin-right: 0;
        }
        .cart-product-name {
            display: -webkit-box; /* wkhtmltopdf uses this one */
            display: flex;
            align-items: center;
            padding-left: 10px;
        }
        .cart-pimage {
            margin-right: 10px;
        }
        .cart-pimage img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
        .cart-product-name .name {
            color: #272727;
            line-height: 1.3;
            font-weight: 500;
            font-size: 12px;
            margin-bottom: 0;
            -webkit-box-pack: center;
        }
        .employee-wrapper {
            height: 50px;
            display: -webkit-box; /* wkhtmltopdf uses this one */
            display: flex;
        }

        .employee-wrapper img {
            width: 30px;
            height: 30px;
            object-fit: cover;
            border-radius: 50%;
            border: 1px solid #cdcdcd;

        }
        .employee-wrapper .employee-name {
            margin-bottom: 0;
            margin-left: 5px;
            text-transform: capitalize;
        }


        .page-break {
            page-break-after: always;
        }

        /*.header, .footer {
            position: fixed;
        }

        .header {
            top: 0;
        }

        .footer {
            bottom: 0;
        }*/
        .invoice-text p {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
            color: #522E91;
        }
        .invoiceno p {
            margin: 0;
            font-size: 18px;
            font-weight: 500;
        }
        .company-information {
            /*max-width: 250px;*/
        }
        .bill-to {
            color: #828080;
        }

        body {
            font-size: 11px;
            font-weight: 400;
            /*color: #4c4c4c;*/
        }
        b {
            font-weight: bold;
            /*color: #000;*/
        }

        .logo img {
            width: 100px;
        }
        .inv-table th {
            padding: 13px 10px;
            font-weight: 600;
            background-color: #f3f3f3;
        }
        .amount {
            font-weight: 500;
        }
        .amount .currency {
            font-weight: 600;
        }
        .inv-table tfoot td {
            border: 0;
            padding: 4px 0;
        }
        .inv-table tfoot tr:first-child td {
            padding-top: 10px;
        }
        .hr {
            height: 1px;
            background-color: red;
        }
    </style>
</head>
<body>

<div class="row header">
    <div>
        <div class="logo">
            <img src="{{ asset('logo/logo.png') }}" alt="{{ \App\Helpers\CommonHelper::getCompanyInformation()['name'] }}">
        </div>
    </div>
    <div class="text-center">
        <div class="invoice-header-text" style="display: inline-block;font-size: 20px;padding: 5px 10px;border-radius: 13px;background-color: #522e91;color: #fff;font-weight: 600;">
            INVOICE
        </div>
    </div>
    <div>
        <div class="invoiceno text-right">
            <table style="float: right;">
                <tr>
                    <th>Invoice ID</th>
                    <td>:</td>
                    <td>#INV-{{ $invoice->invoice_no }}</td>
                </tr>
                <tr>
                    <th>Invoice Date</th>
                    <td>:</td>
                    <td>{{ \App\Helpers\CommonHelper::showDate($invoice->created_at) }}</td>
                </tr>
            </table>
            {{--<p>
                Invoice ID: #INV-{{ $invoice->invoice_no }}
                <br>
                Date: {{ \App\Helpers\CommonHelper::showDate($invoice->created_at) }}
            </p>--}}
        </div>
    </div>
</div>
{{--<div class="hr"></div>--}}
<div class="row header-bottom">
    <div style="max-width:200px;">
        <div class="customer-information">
            <span class="bill-to">
                Bill To
            </span>
            <br>
            <b><span class="cus-name">{{$invoice->customer->full_name}}</span></b> <br>
            <span class="inv-text">{{$invoice->customer->phone}}</span> <br>
            <span class="inv-text">{{$invoice->customer->email}}</span> <br>
            <span class="inv-text">{{$invoice->customer->address}}</span> <br>
        </div>
    </div>
    <div></div>
    <div style="max-width: 200px;">
        <div class="company-information text-right">
            <b><span class="company-name"> {{ \App\Helpers\CommonHelper::getCompanyInformation()['name'] }}</span></b> <br>
            <b><span class="inv-text"> {{$invoice->branch->name}}</span></b> <br>
            <span class="inv-text"> {{ $invoice->branch->contact_phone }}</span> <br>
            <span class="inv-text"> {{ $invoice->branch->address }}</span> <br>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered inv-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th style="width: 25%;text-align: left;">Service</th>
                        <th>Unit Price</th>
                        <th>QTY</th>
                        <th>Discount</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoice->details as $key=>$inv)
                        <tr>
                            <td class="text-center">{{$key+1}}</td>
                            <td>
                                <div class="cart-product-name">
                                    <span class="name" style="text-transform: capitalize;">{{$inv->service->name}}</span>
                                </div>

                            </td>
                            <td class="text-center">
                                <span class="amount">
                                    <span class="currency">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</span>
                                    <span class="value">{{$inv->unit_price}}</span>
                                </span>
                            </td>
                            <td class="text-center">
                                {{$inv->quantity}}
                            </td>

                            <td class="text-center">
                                <span class="amount">
                                    <span class="currency">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</span>
                                    <span class="value">{{$inv->discount_amount}}</span>
                                </span>

                            </td>

                            <td class="text-center">
                                <span class="amount">
                                    <span class="currency">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</span>
                                    <span class="value">{{$inv->payable_amount}}</span>
                                </span>
                            </td>

                        </tr>
                    @endforeach

                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5" class="text-right">Subtotal Amount</td>
                        <td class="totalamount text-center">
                            <span class="amount">
                                <span class="currency">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</span>
                                <span class="value">{{$invoice->total_amount}}</span>
                            </span>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right">Discount Amount</td>
                        <td class="text-center">
                            <span class="amount">
                                <span class="currency">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</span>
                                <span class="value">{{$invoice->discount_amount}}</span>
                            </span>

                        </td>
                    </tr>

                    <tr>
                        <td colspan="5" class="text-right">
                            <b>Total Payable Amount</b>
                        </td>
                        <td class="text-center">
                            <span class="amount">
                                <span class="currency">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</span>
                                <span class="value">{{$invoice->payable_amount}}</span>
                            </span>
                        </td>

                    </tr>

                    <tr>
                        <td colspan="5" class="text-right">
                            {{ ($invoice->previous_wallet_balance < 0)?'Previous Due Balance':'Previous Wallet Balance' }}
                        </td>
                        <td class="text-center">
                            @if($invoice->previous_wallet_balance < 0)
                                <span class="amount">
                                    <span class="currency">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</span>
                                    <span class="value">{{ number_format(makePositiveNumber($invoice->previous_wallet_balance), 2)}}</span>
                                </span>
                            @else
                                <span class="amount">
                                    <span class="currency">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</span>
                                    <span class="value">{{$invoice->previous_wallet_balance}}</span>
                                </span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td colspan="5" class="text-right"><strong>Paid Amount</strong> <small>({{ $invoice->payment_method_text }})</small></td>
                        <td class="text-center">
                            <span class="amount">
                                <span class="currency">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</span>
                                <span class="value">{{$invoice->paid_amount}}</span>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="5" class="text-right">
                            <strong>{{ ($invoice->new_wallet_balance < 0)?'Current Due Balance':'Current Wallet Balance' }}</strong>
                        </td>
                        <td class="text-center">
                            @if($invoice->new_wallet_balance < 0)
                                <span class="amount">
                                    <span class="currency">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</span>
                                    <span class="value">{{ number_format(makePositiveNumber($invoice->new_wallet_balance), 2)}}</span>
                                </span>
                            @else
                                <span class="amount">
                                    <span class="currency">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</span>
                                    <span class="value">{{ $invoice->new_wallet_balance }}</span>
                                </span>
                            @endif

                        </td>
                    </tr>
                    </tfoot>
                </table>
                <br>
                <br>
                <br>
                <div class="w-95prc text-justify mb-5">
                    {{ $invoice->invoice_note }}
                </div>

            </div>
        </div>
    </div>
</div>
</body>
</html>
