@extends('admin.layout.layout')

@section('main_content')
    <div class="row">
        <div class="col-12">
            <div class="card invoice-view">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12 text-right">
                            <span class="inv-no">#INV-{{ $invoicedata->invoice_no }}</span>
                            <span class="inv-text">{{ \App\Helpers\CommonHelper::showDate($invoicedata->created_at) }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <span class="bill-to">
                                Bill To
                            </span>
                            <span class="cus-name">{{$invoicedata->customer->full_name}}</span> <br>
                            <span class="inv-text">{{$invoicedata->customer->phone}}</span> <br>
                            <span class="inv-text">{{$invoicedata->customer->email}}</span> <br>
                            <span class="inv-text">{{$invoicedata->customer->address}}</span> <br>
                        </div>

                        <div class="col-sm-6"></div>
                        <div class="col-sm-3 text-right">
                            <b><span class="company-name"> {{ \App\Helpers\CommonHelper::getCompanyInformation()['name'] }}</span></b> <br>
                            <b><span class="inv-text"> {{$invoicedata->branch->name}}</span></b> <br>
                            <span class="inv-text"> {{ $invoicedata->branch->contact_phone }}</span> <br>
                            <span class="inv-text"> {{ $invoicedata->branch->address }}</span> <br>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="rs-invoice-table">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col" class="text-left">Service</th>
                                        <th scope="col" class="text-left">Staff</th>
                                        <th scope="col">Unit Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Discount</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody">
                                    @foreach($invoicedata->details as $key=>$inv)
                                        <tr>
                                            <td scope="row" class="si">{{$key+1}}</td>
                                            <td>
                                                <div class="cart-product-name">
                                                    <div class="cart-pimage">
                                                        <img src="{{ asset($inv->service->default_image) }}" alt="Hair Cuts">
                                                    </div>
                                                    <span class="name">{{$inv->service->name}}</span>
                                                </div>

                                            </td>
                                            <td>
                                                <div class="employee-wrapper">
                                                    <img src="{{ asset($inv->employee->default_photo) }}" alt="">
                                                    <p class="employee-name">
                                                        {{$inv->employee->user->full_name}}
                                                    </p>
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
                                        <td colspan="6" class="text-right">Subtotal Amount</td>
                                        <td class="totalamount text-center">
                                            <span class="amount">
                                                <span class="currency">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</span>
                                                <span class="value">{{$invoicedata->total_amount}}</span>
                                            </span>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="text-right">Discount Amount</td>
                                        <td class="text-center">
                                            <span class="amount">
                                                <span class="currency">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</span>
                                                <span class="value">{{$invoicedata->discount_amount}}</span>
                                            </span>

                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="6" class="text-right"><strong>Total Payable Amount</strong></td>
                                        <td class="text-center">
                                            <span class="amount">
                                                <span class="currency">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</span>
                                                <span class="value">{{$invoicedata->payable_amount}}</span>
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="6" class="text-right">
                                            {{ ($invoicedata->previous_wallet_balance < 0)?'Previous Due Balance':'Previous Wallet Balance' }}
                                        </td>
                                        <td class="text-center">
                                            @if($invoicedata->previous_wallet_balance < 0)
                                                <span class="amount">
                                                    <span class="currency">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</span>
                                                    <span class="value">{{ number_format(makePositiveNumber($invoicedata->previous_wallet_balance), 2)}}</span>
                                                </span>
                                            @else
                                                <span class="amount">
                                                    <span class="currency">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</span>
                                                    <span class="value">{{$invoicedata->previous_wallet_balance}}</span>
                                                </span>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="6" class="text-right"><strong>Paid Amount</strong> <small>({{ $invoicedata->payment_method_text }})</small></td>
                                        <td class="text-center">
                                            <span class="amount">
                                                <span class="currency">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</span>
                                                <span class="value">{{$invoicedata->paid_amount}}</span>
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="6" class="text-right">
                                            <strong>{{ ($invoicedata->new_wallet_balance < 0)?'Current Due Balance':'Current Wallet Balance' }}</strong>
                                        </td>
                                        <td class="text-center">
                                            @if($invoicedata->new_wallet_balance < 0)
                                                <span class="amount">
                                                    <span class="currency">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</span>
                                                    <span class="value">{{ number_format(makePositiveNumber($invoicedata->new_wallet_balance), 2)}}</span>
                                                </span>
                                            @else
                                                <span class="amount">
                                                <span class="currency">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</span>
                                                <span class="value">{{ $invoicedata->new_wallet_balance }}</span>
                                            </span>
                                            @endif

                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="text-center">
                                <a href="{{route('admin.invoice.pdf',$invoicedata->id)}}?download=pdf" target="_blank" class="btn rsbtn-1">
                                    <i class="fa fa-file-export"></i>
                                    Export PDF
                                </a>
                                &nbsp;&nbsp;
                                <a href="{{route('admin.invoice.pdf',$invoicedata->id)}}" target="_blank" class="btn rsbtn-1 color-primary">
                                    <i class="fa fa-print"></i>
                                    Print
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
@section('page_modals')
@endsection


@section('css_plugins')
    <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
@endsection

@section('js_plugins')
    <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
@endsection

@section('js')
    <script>
        function select2Refresh() {
            $(".form_table .product_select2").select2({
                allowClear: false,
                placeholder: "Search Service"
            });
        }

        function employeeSelect2() {
            $(".form_table .employee-select2").select2({
                allowClear: false,
                placeholder: "Search Employee"
            });
        }

        function customerSelect2() {
            $(".customer-group .customer-select2").select2();
        }

        var product_list = [];
        var single_product;
        $(document).ready(function () {
            customerSelect2();
            employeeSelect2();
            select2Refresh();

            $("#addServiceBtn").click(function () {
                let html = $("#new_service_row table tbody").html();
                $("#tbody").append(html);
                select2Refresh();
                countsinumber();
            });
        })

    </script>

@endsection
