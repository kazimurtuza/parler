@extends('admin.layout.layout')

@section('main_content')
    <div class="row">
        <div class="col-12">
            <form action="{{route('admin.invoice.update')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label>Branch<span class="text-danger">*</span></label>
                            <select name="branch_id" class="form-control default-select branch" required>
                                @foreach($branches as $branch)
                                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="col-4"><input type="hidden" name="invoice_id" value="{{$invoicedata->id}}"></div>
                    <div class="col-4">
                        <div class="form-group customer-group">
                            <label>Customer<span class="text-danger">*</span></label>
                            <select name="customer_id" id="customer_select" class="form-control customer-select2"
                                    required>
                                @foreach($customers as $customer)
                                    <option value="{{$customer->id}}" {{$invoicedata->customer_id==$customer->id?'selected':''}}>{{$customer->full_name}}</option>
                                @endforeach

                            </select>
                        </div>

                    </div>


                    <div class="col-12">
                        <div class="rs-table-wrapper">

                            <table class="table table-bordered form_table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Service</th>
                                    <th scope="col">Unit Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Discount Type</th>
                                    <th scope="col">Discount</th>
                                    <th scope="col">Employee</th>
                                    <th scope="col">Total</th>
                                    <th scope="col"><i class="fa fa-cog"></i></th>
                                </tr>
                                </thead>
                                <tbody id="tbody">
                                @foreach($invoicedata->details as $key=>$inv)
                                    <tr>
                                        <th scope="row" class="si">{{$key+1}}</th>
                                        <td>
                                            <input type="hidden" name="invoice_detail_id[]" value="{{$inv->id}}">
                                            <select name="service_id[]" class="form-control product product_select2"
                                                    onchange="changeProduct(this)" required>
                                                @foreach($services as $service)
                                                    <option value="{{$service->id}}"
                                                            {{$inv->service_id==$service->id?'selected':''}} data-discount-value="{{$service->discount_value}}"
                                                            data-discount-type="{{$service->discount_type}}"
                                                            data-price="{{$service->service->price}}">{{$service->service->name}}</option>
                                                @endforeach

                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" min="1" value="{{$inv->unit_price}}" step="any"
                                                   name="unit_price[]"
                                                   class="form-control price" oninput="changePrice(this)">
                                        </td>
                                        <td>
                                            <input type="number" value="{{$inv->quantity}}" value="1" step="any"
                                                   name="quantity[]"
                                                   class="form-control quantity" oninput="changeQty(this)">
                                        </td>
                                        <td>
                                            <select name="discount_type[]" class="form-control distype"
                                                    onchange="subtotal(this)" required>
                                                <option value="">-SELECT-</option>
                                                <option value="0" {{$inv->discount_type==0?'selected':''}}>Fixed
                                                </option>
                                                <option value="1" {{$inv->discount_type==1?'selected':''}}>Percentage
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" min="0" value="{{$inv->discount_value}}" step="any"
                                                   name="discount[]"
                                                   class="form-control discount_amount"
                                                   oninput="changeDiscountamount(this)"
                                                   required>
                                        </td>

                                        <td>
                                            <select name="employee_id[]" class="form-control employee-select2" required>

                                                @foreach($employees as $emp)
                                                    <option value="{{$emp->id}}" {{$invoicedata->employee_id==$emp->id?'selected':''}}>{{$emp->user->full_name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <span class="total">{{$inv->payable_amount}}</span>
                                        </td>
                                        <td>
                                            @if(!$loop->first)
                                                <button type="button" class="btn btn-xs btn-danger"
                                                        onclick="removeProductRow(this)">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="6"></td>
                                    <td class="text-center">Subtotal</td>
                                    <td class="totalamount">{{$invoicedata->total_amount}}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td>Discount Type</td>
                                    <td><select name="customer_discount_type" id="customer_discount_type"
                                                class="form-control distype"
                                                onchange="totalamount(this)" required>
                                            <option value="0" {{$invoicedata->discount_type==0?'selected':''}}>Fixed
                                            </option>
                                            <option value="1" {{$invoicedata->discount_type==1?'selected':''}}>
                                                Percentage
                                            </option>
                                        </select></td>
                                    <td colspan="1">Discount Value</td>
                                    <td><input type="number" name="customer_discount_val" oninput="totalamount(this)"
                                               id="customer_discount_value" value="{{$invoicedata->discount_value}}"
                                               class="form-control"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="6"></td>
                                    <td>Discount</td>
                                    <td><span class="netdiscount">{{$invoicedata->discount_amount}}</span></td>

                                </tr>
                                <tr>
                                    <td colspan="6"></td>
                                    <td>Net amount</td>
                                    <td><span class="nettotal">{{$invoicedata->payable_amount}}</span></td>

                                </tr>
                                <tr>
                                    <td colspan="4"></td>
                                    <td colspan="1">Paying By</td>
                                    <td colspan="1"><select name="bank_account_id" class="form-control" required>
                                            <option value="">-SELECT-</option>
                                            @foreach($bankAccounts as $bank)
                                                <option value="{{$bank->id}}" {{$bank->id===$invoicedata->bank_account_id ?'selected':''}}>{{$bank->name}}</option>
                                            @endforeach
                                        </select></td>
                                    <td>Paying Amount</td>
                                    <td><input type="number" step="any" class="form-control" id="paying_amount"
                                               value="{{$invoicedata->payable_amount}}" name="amount" required></td>

                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <button class="btn rsbtn-1 color-primary" id="addServiceBtn" type="button">+ Add</button>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <button class="btn w-25 rsbtn-1 bg-success" type="submit">Submit</button>
                    </div>


                </div>
            </form>
        </div>
        <div style="display: none" id="hidden_data">
            <div id="new_service_row">
                <table>
                    <tbody>
                    <tr>
                        <th scope="row" class="si">1</th>
                        <td>
                            <select name="service_id[]" class="form-control  product_select2"
                                    onchange="changeProduct(this)" required>
                                <option value="">-SELECT</option>
                                @foreach($services as $service)
                                    <option value="{{$service->id}}" data-discount-value="{{$service->discount_value}}"
                                            data-discount-type="{{$service->discount_type}}"
                                            data-price="{{$service->service->price}}">{{$service->service->name}}</option>
                                @endforeach

                            </select>
                        </td>
                        <td>
                            <input type="number" min="1" value="0" step="any" name="unit_price[]"
                                   class="form-control price" oninput="changePrice(this)" required>
                        </td>
                        <td>
                            <input type="number" min="0" value="1" step="any" name="quantity[]"
                                   class="form-control quantity" oninput="changeQty(this)" required>
                        </td>
                        <td>
                            <select name="discount_type[]" class="form-control distype" onchange="subtotal(this)"
                                    required>
                                <option value="">-SELECT-</option>
                                <option value="0">Fixed</option>
                                <option value="1">Percentage</option>
                            </select>
                        </td>
                        <td>
                            <input type="number" min="0" value="1" step="any" name="discount[]"
                                   class="form-control discount_amount" oninput="changeDiscountamount(this)" required>
                        </td>

                        <td>
                            <select name="employee_id[]" class="form-control employee-select2" required>
                                <option value="">-SELECT-</option>
                                @foreach($employees as $emp)
                                    <option value="{{$emp->id}}" {{$invoicedata->employee_id==$emp->id?'selected':''}}>{{$emp->user->full_name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <span class="total">0</span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-xs btn-danger" onclick="removeProductRow(this)"><i
                                        class="fa fa-times"></i></button>
                        </td>
                    </tr>
                    </tbody>
                </table>
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

            $('.branch').on('change', function () {
                let branch_id = $(this).val();
                let urldata = "{{route('admin.branch_wise.data')}}";

                $.ajax({
                    url: urldata,
                    type: 'GET',
                    data: {
                        branch_id: branch_id,
                    },
                    success: function (res) {
                        $("#customer_select").html(res.customer_view);
                        customerSelect2();
                        $(".product_select2").html(res.service_view);
                        select2Refresh();
                        $(".employee-select2").html(res.employee_view);
                        employeeSelect2();

                    }
                });
            })


        });

        function removeProductRow(button) {
            $(button).parent().parent().remove();
            countsinumber();
            totalamount();
        }

        function changeProduct(product) {
            let unnitprice = +$('option:selected', product).attr('data-price');
            let discount_type = +$('option:selected', product).attr('data-discount-type');
            let discount_value = +$('option:selected', product).attr('data-discount-value');

            let selectdata = $(product).parent().parent();
            selectdata.find('.discount_amount').val(discount_value);
            selectdata.find('.distype').val(discount_type).change();
            selectdata.find('.quantity').val(1);
            selectdata.find('.price').val(unnitprice);
            subtotal(product)
        }

        function changePrice(input) {
            let unnitprice = $(input).val();
            let qut = $(input).parent().parent().find('.quantity').val();
            let total = (qut * unnitprice).toFixed(2)
            $(input).parent().parent().find('.total').html(total);
            subtotal(input)
        }

        function changeQty(input) {
            let qty = $(input).val();
            let unnitprice = $(input).parent().parent().find('.price').val();
            let total = (qty * unnitprice).toFixed(2)
            subtotal(input)
        }

        function changeDiscountamount(data) {
            subtotal(data)
        }


        function subtotal(data) {
            let selectdata = $(data).parent().parent();
            let discount_type = +selectdata.find('.distype').val();
            let dis_amount = +selectdata.find('.discount_amount').val();
            let unit_price = +selectdata.find('.price').val();
            let qty = +selectdata.find('.quantity').val();
            let total = qty * unit_price;
            let discunt = 0;
            if (discount_type == 1) {
                discunt = (total * dis_amount) / 100;
            }
            if (discount_type == 0) {
                discunt = dis_amount * qty;
            }

            let subtotal = (total - discunt).toFixed(2);

            selectdata.find('.total').html(subtotal);
            totalamount()
        }

        function countsinumber() {
            let i = 1;
            $('.si').each(function (index, data) {

                $(data).html(i);
                i = i + 1;
            })
        }

        function totalamount() {
            let total = 0;
            $('.total').each(function (index, data) {
                $price = +$(data).html();
                total += $price
            });
            $('.totalamount').html(total.toFixed(2));

            let discount_type = +$('#customer_discount_type').val();
            let dis_amount = +$('#customer_discount_value').val();

            if (discount_type == 1) {
                discunt = (total * dis_amount) / 100;
            }
            if (discount_type == 0) {
                discunt = dis_amount;
            }
            $('.netdiscount').html(discunt.toFixed(2));
            $('.nettotal').html((total - discunt).toFixed(2));
            $('#paying_amount').val((total - discunt).toFixed(2))
        }


    </script>

@endsection
