@extends('admin.layout.layout')

@section('css')
    <style>
        .discountstyle{
            height: 30px !important;
            border-radius: 9px !important;  font-size: 10px;
            font-weight: 600;
        }
        .amounttop{
            margin-top: 30px;
            color:green;
        }
        .grand-discount-wrapper{
            margin-top: 30px;
        }
        #disAmount{
            color:green;
        }
        .discolor{
            width: 100px;
            color:green !important;
        }
        #totalvat{
            font-size: 15px;
            font-weight: 500;
            color: #000;
        }
        .prcstyle{
            width: 98px;
            margin-left: 29px;
        }

    </style>
@endsection

@section('main_content')
    <form action="{{route('admin.store_pos')}}" method="post" onsubmit="return checkValidation()">
        @csrf
        <div class="row g-2 g-md-5 ">

            @if(isAdmin())
                <div class="col-sm-6">
                    <select name="branch_id" class="form-control branch_select2" onchange="produnctlist(this.value)"
                            id="branchid">
                        <option value="">-SELECT-</option>
                        @foreach($branches as $branch)
                            <option value="{{$branch->id}}">{{$branch->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-6"></div>
            @endif


            <div class="col-sm-7 p-1 pr-30px ">
                <div class="row">
                    <div class="col-sm-12">
                        <input type="text" class="form-control" oninput="serviceSrc(this.value)"
                               placeholder="Search Service">
                    </div>

                </div>

                <div class="row p-3 " id="productList">
                </div>
            </div>
            <div class="col-sm-5 p-1 ">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body pl-10px pr-10px">
                                <div class="row mb-3">
                                    <div class="col-sm-8">
                                        <select name="customer_id" class="form-control customer_select2" id="change_customer" onchange="changeCustomer(this)" required>
                                            @foreach($customers as $customer)
                                                <option value="{{$customer->id}}"
                                                        customer-blance="{{$customer->available_balance}}"
                                                        customer-disval="{{$customer->membership->discount_value}}"
                                                        customer-candue="{{$customer->can_due}}"
                                                        customer-disType="{{$customer->membership->discount_type}}">{{$customer->full_name}}
                                                    ({{ $customer->phone }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-4">
                                        <button class="btn rsbtn-1 color-primary" type="button" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                                            <span class="btn-icon-start text-info">
                                                <i class="fa fa-plus color-info"></i>
                                            </span>
                                            Add
                                        </button>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table pos-cart-table">
                                            {{--<thead>
                                            <tr>
                                                <th style="width: 30%;">Name</th>
                                                <th style="text-align: center;">Staff</th>
                                                <th style="width: 18%;">Quantity</th>
                                                <th style="display: none;">Unit Price</th>
                                                <th style="display: none;">Discount</th>
                                                <th style="width: 15%;">Total</th>
                                                <th class="text-right" style="width: 2%;">
                                                    <i class="fa fa-trash"></i>
                                                </th>
                                            </tr>
                                            </thead>--}}
                                            <tbody id="tbody">


                                            </tbody>
                                            {{--modal payment--}}
                                            <div class="modal fade" id="payAmount">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Finalize Sale</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body pos-payment-modal">
                                                            <div class="wallet-show-wrapper">
                                                                <p class="wsw-text">
                                                                    <span class="wsw-title">
                                                                        Wallet Balance
                                                                    </span>
                                                                    <span class="wsw-subtitle">
                                                                        New Wallet Balance
                                                                    </span>
                                                                    <span class="wsw-subtitle-amount">
                                                                        <span class="currency">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</span>
                                                                        <span class="amount" id="after_available_blc"></span>
                                                                    </span>
                                                                </p>
                                                                <p class="wsw-amount">
                                                                    <span class="currency">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</span>
                                                                    <span class="amount" id="available_blc">0</span>
                                                                </p>
                                                            </div>

                                                            <div class="pay-by-wrapper mt-4">
                                                                <div class="row align-items-center">
                                                                    <div class="col-sm-7">
                                                                        <label>Pay By</label>
                                                                    </div>
                                                                    <div class="col-sm-5">
                                                                        <select name="bank_account_id" id="accountList" class="default-select form-control wide" required>
                                                                            <option>Payment Method</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="total-payable-amount-wrapper mt-5">
                                                                <div class="row align-items-center">
                                                                    <div class="col-sm-6">
                                                                        <label>Total Payable Amount</label>
                                                                    </div>
                                                                    <div class="col-sm-6 text-right">
                                                                        <label class="total-payable-amount">
                                                                            <span class="currency">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</span>
                                                                            <span class="amount" id="total_payable">0</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="paid-amount-wrapper mt-2">
                                                                <div class="row align-items-center">
                                                                    <div class="col-sm-7">
                                                                        <label>Paid Amount</label>
                                                                    </div>
                                                                    <div class="col-sm-5">
                                                                        <input type="number" name="amount" id="customer_pay" min="0" value="0" oninput="submitpayment()" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="due-amount-wrapper mt-4">
                                                                <div class="row align-items-center">
                                                                    <div class="col-sm-6">
                                                                        <label>Due Amount</label>
                                                                    </div>
                                                                    <div class="col-sm-6 text-right">
                                                                        <label class="due-amount">
                                                                            <span class="currency">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</span>
                                                                            <span class="amount" id="total_due">0</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer justify-content-center">
                                                            <div class="text-center">
                                                                <button type="submit" class="btn rsbtn-1 color-primary ">Submit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <tfoot>
                                            <tr class="small-padding pt-15px tt">
                                                <td colspan="1">
                                                    <label>Total Item:</label>
                                                    <span id="totalitem">0</span>
                                                </td>
                                                <td colspan="2" class="text-right">
                                                    <label>Total Amount:</label>
                                                </td>
                                                <td colspan="1" id="subtotal" class="text-right">0</td>
                                                <td></td>
                                            </tr>
                                            <tr class="small-padding pb-15px">
                                                <td colspan="2" class="">
                                                    <div class="mb-4px">
                                                        <label class="discolor">Discount:</label>
                                                        <input type="hidden" name="customer_discount_type select" id="custom_dis_type" value="0">

                                                        <div class="row">
                                                            <div class="col-8">
                                                                <select name=""  class="form-control default-select discountstyle"  onchange="changeCustomerDiscountType(this)" id="">
                                                                    <option value="1" > Percentage (%)</option>
                                                                    <option value="0"> Fixed ( {{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }} )</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-4">
                                                                <input type="number" name="customer_discount_val" class="customer_discount_val form-control discolor" id="disval" value="0">
                                                            </div>
                                                        </div>




                                                        &nbsp;&nbsp;&nbsp;
                                                        {{--<span class="customer-discount-type-badge">--}}
                                                            {{--<span class="badge cdtb-percent" title="Percent" onclick="changeCustomerDiscountType(1, this)">%</span>--}}
                                                            {{--<span class="cdtb-currency selected" title="Fixed"  onclick="changeCustomerDiscountType(0, this)"><b>{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</b></span>--}}
                                                        {{--</span>--}}
                                                    </div>


                                                </td>
                                                <td colspan="1" class="text-right">
                                                    <label class="amounttop">Amount:</label>
                                                </td>
                                                <td colspan="1" class="text-right">
                                                    <div class="grand-discount-wrapper">
                                                <span class="disAmount" id="disAmount">
                                                    <b>{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</b> 0
                                                </span>
                                                    </div>
                                                </td>
                                                <td></td>

                                            </tr>
                                            <tr class="border-top">
                                                <td colspan="2" class="text-right">
                                                    <div class="row">
                                                        <div class="col-7">
                                                            Vat (%)
                                                        </div>
                                                        <div class="col-5">
                                                            <select name=""  class="form-control default-select discountstyle prcstyle"  onchange="changeCustomerDiscountType(this)" id="">
                                                              @foreach($vatTax as $vat)
                                                                    <option value="{{$vat->vat_percent}}" {{$vat->is_default==1?'selected':''}}>{{$vat->vat_percent}}</option>
                                                                  @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="1" class="text-right">
                                                    <label >Total Vat &nbsp;:</label>
                                                </td>

                                                <td colspan="1" class="text-right" id="totalvat">0</td>
                                                <td></td>

                                            </tr>
                                            <tr class="border-top">
                                                <td colspan="3" class="text-right">
                                                    <label class="font-size-15">Total Payable &nbsp;:</label>
                                                </td>

                                                <td colspan="1" class="text-right" id="totalpayable">0</td>
                                                <td></td>

                                            </tr>
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <button type="button" class="btn btn-sm btn-success font-size-14" data-bs-toggle="modal"
                                                            data-bs-target="#payAmount" onclick="submitpayment()">Payment
                                                    </button>
                                                </td>

                                            </tr>
                                            </tfoot>
                                            {{--<tfoot>
                                            <tr>
                                                <td colspan="1">Total Item:</td>
                                                <td colspan="1" id="totalitem">0</td>
                                                <td colspan="1">Total:
                                                </td>
                                                <td colspan="1" id="subtotal">0</td>
                                                <td></td>

                                            </tr>
                                            <tr>
                                                <td colspan="1">Discount Type</td>
                                                <td colspan="1"><select name="customer_discount_type" id="custom_dis_type"
                                                                        class="form-control">
                                                        <option value="0">Fixed</option>
                                                        <option value="1">Percentage</option>
                                                    </select></td>
                                                <td colspan="1">Discount</td>
                                                <td colspan="1"><input type="number" name="customer_discount_val" id="disval"
                                                                       class="form-control w-100" value="0"></td>
                                                <td colspan="1">Amount:
                                                </td>
                                                <td colspan="1" id="disAmount">0</td>


                                            </tr>
                                            <tr>
                                                <td colspan="4">Total Payable:</td>

                                                <td colspan="1" id="totalpayable">0</td>
                                                <td></td>

                                            </tr>

                                            <tr>
                                                <td colspan="5"></td>
                                                <td colspan="1">
                                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                            data-bs-target="#payAmount" onclick="submitpayment()">Payment
                                                    </button>
                                                </td>

                                            </tr>
                                            </tfoot>--}}
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


            </div>

        </div>
    </form>
    <div>
        <table style="display: none;">
            <tbody id="invtr">
            <tr class="product">
                <td style="width: 35%;">
                    <div>
                        <input type="hidden" name="discount_type[]" class="discount_type">
                        <input type="hidden" name="service_id[]" class="product_id">
                    </div>
                    <div class="cart-product-name">
                        <div class="cart-pimage">
                            <img src="" alt="">
                        </div>
                        <span class="name">-</span>
                    </div>
                    <div class="unit-price-wrapper">
                        <p class="unit-price-text">Unit Price : <b class="unitcurr">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</b></p>
                        <input type="number" name="unit_price[]" oninput="changeQty(this)" class="form-control price unit-price" required>
                    </div>
                </td>

                <td style="width: 35%;">
                    <div class="employee-wrapper">
                        <img src="{{ asset('assets/profile.png') }}" alt="" class="employee-img-element">
                        <select name="employee_id[]" class="form-control employee" required onchange="changeEmployee(this)">
                            <option value="">Select Staff</option>
                        </select>
                    </div>
                    <div class="discount-wrapper">
{{--                        <p class="m-0 text-center discount-type-txt"></p>--}}
                        <p class="discount-dtext">Discount:</p>
                        <input oninput="changeQty(this)" type="number" name="discount[]" class="form-control discount">
                        <span class="badge discount-badge">%</span>
                    </div>

                </td>
                <td>
                    <div class="qty-input-wrapper">
                        <button class="btn qtychangebtn minus decrementQty" onclick="decrementQty(this)" type="button"><i class="fa fa-minus"></i></button>
                        <input type="number" name="quantity[]" oninput="changeQty(this)" value="1"
                               class="form-control quantity qty-input" required>
                        <button class="btn qtychangebtn plus incrementQty" onclick="incrementQty(this)" type="button"><i class="fa fa-plus"></i></button>
                    </div>
                </td>
                <td style="display: none;">
                    <div>
                        <input type="number" name="unit_price_old[]" oninput="changeQty(this)" class="form-control price" required>
                    </div>
                </td>
                <td style="display: none;">

                </td>
                <td style="width: 25%;text-align: right;">
                    <span class="total"></span>
                </td>
                <td class="text-right">
                    <button class="btn cart-delete-btn" onclick="deleteitem(this)"><i class="fa fa-times"></i></button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

@endsection

@section('page_modals')
    <form action="{{ route('admin.customer.store') }}" onsubmit="submitCustomer()" id="addBranchForm" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="addCustomerModal">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" >
                                </div>
                            </div>

                        </div>
                        <div class="row mt-4">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Membership<span class="text-danger">*</span></label>
                                    <select name="customer_membership_id" id="customer_membership_id" class="default-select form-control wide" required >
                                        <option value="">Choose Membership Plan</option>
                                        @foreach($memberships as $membership)
                                            <option value="{{$membership->id}}">{{$membership->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Available Balance <span class="text-danger">*</span></label>
                                    <input type="number" id="available_balance" class="form-control"  name="available_balance" value="0" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select class="default-select form-control wide" id="gender" name="gender" value="{{ old('gender') }}">
                                        <option value="">-SELECT-</option>
                                        <option value="0">Male</option>
                                        <option value="1">Female</option>
                                        <option value="2">Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Blood Group</label>
                                    <select name="blood" id="blood" class="default-select form-control wide">
                                        <option value="">Select</option>
                                        @if(!empty($blood_groups))
                                            @foreach($blood_groups as $blood_group)
                                                <option value="{{ $blood_group }}" {{ (old('blood') == $blood_group)?'selected':'' }}>{{ $blood_group }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row mt-4 mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>photo</label>
                                    <input type="file" class="dropify" id="photo" name="photo" accept="image/*" data-height="140" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label>DOB</label>
                                    <input type="date" class="datepicker-default form-control" id="dob" name="dob" value="{{ old('dob') }}" placeholder="YYYY-MM-DD">
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea class="form-control" name="address" id="address" rows="10" placeholder="Address"></textarea>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-rounded btn-dark" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn rsbtn-1 color-primary" >Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection



@section('css_plugins')
    <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
    @include('admin.partials._pickdate_css')
    @include('admin.partials._dropify_css')
@endsection

@section('js_plugins')
    <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
    @include('admin.partials._pickdate_js')
    @include('admin.partials._dropify_js')
@endsection

@section('js')
    <script>
        function employeeSelect2() {
            $(".pos-cart-table .employee").select2({
                dropdownCssClass: "employee-select2-dropdown",
                containerCssClass : "employee-select2-container"
            });
        }
        $(document).ready(function () {
            $(".branch_select2").select2();
            $(".customer_select2").select2();
            @if(!isAdmin())
                produnctlist({{myBranchId()}})
            @endif
            employeeSelect2();

        });

        function produnctlist(branch_id) {
            $.ajax({
                url: "{{route('admin.pos.product')}}",
                type: "get",
                data: {
                    branch_id: branch_id,
                },
                success: function (response) {

                    $('#productList').html(response[1]);
                    $('.employee-wrapper .employee').html(response[0]);
                    $('#accountList').html(response[2]);
                    $('.default-select').niceSelect('update');
                },
                error: function (xhr) {
                    //Do Something to handle error
                }
            });

        }

        function serviceSrc(src_val) {
            let branchid
            @if(isAdmin())
                branchid = $('#branchid').val()
            @else
                branchid = {{myBranchId()}}
            @endif

            $.ajax({
                url: "{{route('admin.pos.productsrc')}}",
                type: "get",
                data: {
                    branch_id: branchid,
                    product_name: src_val,
                },
                success: function (response) {

                    $('#productList').html(response)

                },
                error: function (xhr) {
                    //Do Something to handle error
                }
            });
        }

        function addProduct(data) {
            let product_id = $(data).attr('data-productId');
            let price = +$(data).attr('data-price');
            let name = $(data).attr('data-name');
            let image = $(data).attr('data-image');
            let disVal = +$(data).attr('data-discountVal');
            let distype = $(data).attr('data-discountType');
            let distype_val = +$(data).attr('data-discountType-val');

            let prev_data_matched = false;
            $('#tbody .product_id').each(
                function () {
                    let val = +$(this).val();

                    if(val==product_id){
                      let oldQty=+$(this).parent().parent().parent().find('.quantity').val();
                      $(this).parent().parent().parent().find('.quantity').val(oldQty+1);
                        changeQty(this);
                        prev_data_matched = true;
                    }
                }
            );

            if (prev_data_matched == true) {
                subtotal();
                return 0;
            }


            $('#invtr .discount_type').attr('value', distype_val);
            $('#invtr .price').attr('value', price);
            $('#invtr .product_id').attr('value', product_id);
            $('#invtr .name').html(name);
            $('#invtr .cart-pimage img').attr('src', image);
            $('#invtr .cart-pimage img').attr('alt', name);
            if(distype_val == 0) {
                $("#invtr .discount-badge").html("{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}")
            } else {
                $("#invtr .discount-badge").html("%")
            }
            // $('#invtr .discount-type-txt').html(distype);
            // $('#invtr .discount').val(disVal);
            let totaldiscount = 0;
            if (distype_val === 0) {
                totaldiscount = +disVal;
            }
            if (distype_val === 1) {
                totaldiscount = (price * disVal) / 100;
            }

            $('#invtr .discount').attr('value', disVal);
            $('#invtr .total').html("{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }} <span class='amount'>"+(price - totaldiscount).toFixed(2)+"</span>")

            let addlist = $('#invtr').html();
            $('#tbody').append(addlist);

            subtotal();
            employeeSelect2();

        }

        function deleteitem(data) {
            $(data).parent().parent().remove();
            subtotal()
        }

        $('#disval').on('input', function () {
            subtotal();
        })

        $('#custom_dis_type').on('change', function () {
            subtotal();
        });
        function changeCustomerDiscountType(button) {
            $("#custom_dis_type").val($(button).val());
            $(button).parent().find('span').removeClass('selected');
            $(button).addClass('selected');
            subtotal();
        }

        function subtotal() {
            let subtotal = 0;
            let vat_prc =15;
            let qty = 0;
            $('#tbody .total').each(
                function () {
                    let val = +$(this).find(".amount").html();
                    subtotal += val;
                }
            );
            $('#tbody .quantity').each(
                function () {
                    let itemqty = +$(this).val();
                    qty += itemqty;
                }
            );
            $('#subtotal').html("<b>{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</b> "+subtotal.toFixed(2));
            $('#totalitem').html(qty);

            let discount_amount = 0;
            let dis_type = +$('#custom_dis_type').val()
            let dis_val = +$('#disval').val()
            if (dis_type === 0) {
                discount_amount = dis_val
            }
            if (dis_type === 1) {
                discount_amount = (dis_val * subtotal) / 100;
            }

            let total_val   =((subtotal - discount_amount)*vat_prc)/100;

            if(total_val>300){
                total_val=300;
            }

            $('#totalvat').html(total_val.toFixed(2));


            $('#disAmount').html("<b>{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</b> "+discount_amount.toFixed(2));
            $('#totalpayable').html("<b>{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }}</b> <span class='amount'>"+(subtotal - discount_amount+total_val).toFixed(2)+"</span>");


        }

        function changeQty(data) {

            let totaldiscount = 0;
            let qty = +$(data).parent().parent().parent().find('.quantity').val();
            let price = +$(data).parent().parent().parent().find('.price').val();

            let distype = +$(data).parent().parent().parent().find('.discount_type').val();
            let disval = +$(data).parent().parent().parent().find('.discount').val();
            if (distype === 0) {
                totaldiscount = disval * qty;
            }
            if (distype === 1) {
                totaldiscount = ((price * qty) * disval) / 100;
            }
            // $(data).parent().parent().parent().find('.total').html((price * qty).toFixed(2) - totaldiscount.toFixed(2));
            $(data).parent().parent().parent().find('.total').html("{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }} <span class='amount'>"+((price * qty) - totaldiscount).toFixed(2)+"</span>");
            subtotal();
        }

        // $('#change_customer').on('change', function () {
        //     $dicount_value = +$('option:selected', this).attr('customer-disval');
        //     $dicount_type = +$('option:selected', this).attr('customer-disType');
        //
        //     $('#custom_dis_type').val($dicount_type)
        //     $('#disval').val($dicount_value)
        //
        //     subtotal();
        //
        //
        // })
        function changeCustomer(data){
            $dicount_value = +$('option:selected', data).attr('customer-disval');
            $dicount_type = +$('option:selected', data).attr('customer-disType');

            $('#custom_dis_type').val($dicount_type)
            $('#disval').val($dicount_value)

            subtotal();

        }

        function submitpayment(){
            event.preventDefault()

            let customer_payinput=+$('#customer_pay').val();
            let available_balance=+$('#change_customer option:selected').attr('customer-blance');

            let toaldiscount=+$('#disAmount').html();
            let totalpayable=+$('#totalpayable .amount').html();
            let totalitem=+$('#totalitem').html();
            let total_due=totalpayable-(customer_payinput+available_balance);
            let after_pay_available=(customer_payinput+available_balance)-totalpayable;
            if(total_due<0){
                total_due=0
            }
            payable_total_amount = totalpayable;
            if(after_pay_available<0){
                after_pay_available=0
            }

            $('#total_item').html(totalitem)
            $('#total_payable').html(totalpayable);
            // $('.total_payable').val(totalpayable);
            $('#total_due').html(total_due)

            $('#available_blc').html(available_balance)
            $('#after_available_blc').html(after_pay_available)

        }

        function submitCustomer(){
            event.preventDefault()
            let first_name=$('#first_name').val()
            let last_name=$('#last_name').val()
            let customer_membership_id=$('#customer_membership_id').val()
            let available_balance=$('#available_balance').val()
            let phone=$('#phone').val()
            let email=$('#email').val()
            let photo=$('#photo').val()
            let dob=$('#dob').val()
            let gender=$('#gender').val()
            let blood=$('#blood').val()
            let address=$('#address').html()


            let route = "{{ route('admin.customer.ajaxadd') }}";
            let token = "{{ csrf_token()}}";
            $.ajax({
                url: route,
                type: 'POST',
                data: {
                    _token:token,
                    first_name:first_name,
                    last_name:last_name,
                    customer_membership_id:customer_membership_id,
                    available_balance:available_balance,
                    phone:phone,
                    email:email,
                    photo:photo,
                    dob:dob,
                    gender:gender,
                    blood:blood,
                    address:address,
                },
                success: function(response) {

                    $('#change_customer').html(response);
                    changeCustomer($('#change_customer'));
                    $('#addCustomerModal').modal('hide');

                },
                error: function(xhr) {
                    //Do Something to handle error
                }});

        }

        function incrementQty(button) {
            let qty = $(button).parent().find('.quantity').val();
            qty = parseInt(qty);
            qty++;
            $(button).parent().find('.quantity').val(qty);
            changeQty($(button).parent().find('.quantity'));
        }
        function decrementQty(button) {
            let qty = $(button).parent().find('.quantity').val();
            qty = parseInt(qty);
            if(qty <= 1) {
                qty = 1;
            } else {
                qty--;
            }
            $(button).parent().find('.quantity').val(qty);
            changeQty($(button).parent().find('.quantity'));
        }

        function changeEmployee(select) {
            // let photo = $(select).select2().find(":selected").attr("data-photo");
            let photo = $('option:selected', select).attr('data-photo');
            // console.log(photo);
            if (photo === undefined) {
                photo = "{{ asset('assets/profile.png') }}";
            }
            $(select).parent().find(".employee-img-element").attr('src', photo);
        }
        var payable_total_amount = 0;
        function checkValidation() {
            let candue = $('#change_customer option:selected').attr('customer-candue');
            if (candue == '1') {
                return true;
            }
            let paid_amount = $("#customer_pay").val();
            if (paid_amount < payable_total_amount) {
                showInfoAlert('This Customer has no access to set due!');
                return false;
            }
            if (paid_amount > payable_total_amount) {
                showInfoAlert('This Customer has no access to set wallet balance!');
                return false;
            }
            return true;

        }
    </script>

@endsection
