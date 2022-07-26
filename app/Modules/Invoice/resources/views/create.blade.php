@extends('admin.layout.layout')

@section('main_content')
    <div class="row">
        <div class="col-12">
            <form action="{{route('admin.invoice.store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-4">
                        @if(isAdmin())
                            <div class="form-group">
                                <label>Branch<span class="text-danger">*</span></label>
                                <select name="branch_id" class="form-control select2 branch"
                                        onchange="changedBranch(this.value)" required>
                                    <option value="">-SELECT-</option>
                                    @foreach($branches as $branch)
                                        <option value="{{$branch->id}}">{{$branch->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                    </div>
                    <div class="col-4"></div>
                    <div class="col-4">
                        <div class="form-group customer-group">
                            <label>Customer<span class="text-danger">*</span></label>
                            <select name="customer_id" id="customer_select" class="form-control customer-select2"
                                    required>
                                <option value="">-SELECT-</option>
                                <option data-addcustomer="add">+ Add Customer</option>

                            </select>
                        </div>

                    </div>


                    <div class="col-12">
                        <div class="rs-table-wrapper">

                            <table class="table table-bordered form_table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" style="width: 40px;">Service</th>
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
                                <tr>
                                    <th scope="row" class="si">1</th>
                                    <td class="selectDown">
                                        <select name="service_id[]"
                                                class="form-control product product_select2 services"
                                                onchange="changeProduct(this)" required>
                                            <option value="">-SELECT-</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" min="1" value="0" step="any" name="unit_price[]"
                                               class="form-control price" oninput="changePrice(this)">
                                    </td>
                                    <td>
                                        <input type="number" min="0" value="1" step="any" name="quantity[]"
                                               class="form-control quantity" oninput="changeQty(this)">
                                    </td>
                                    <td>
                                        <select name="discount_type[]" class="form-control distype"
                                                onchange="subtotal(this)" required>
                                            <option value="">-SELECT-</option>
                                            <option value="0">Fixed</option>
                                            <option value="1">Percentage</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" min="0" value="1" step="any" name="discount[]"
                                               class="form-control discount_amount" oninput="changeDiscountamount(this)"
                                               required>
                                    </td>

                                    <td>
                                        <select name="employee_id[]" class="form-control employee-select2" required>
                                            <option value="">-SELECT-</option>
                                        </select>
                                    </td>
                                    <td>
                                        <span class="total">0</span>
                                    </td>
                                    <td></td>
                                </tr>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="6"></td>
                                    <td class="text-center">Subtotal</td>
                                    <td class="totalamount"></td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td>Discount Type</td>
                                    <td>
                                        <select name="customer_discount_type" id="customer_discount_type"
                                                class="form-control distype"
                                                onchange="totalamount(this)" required>
                                            <option value="0">Fixed</option>
                                            <option value="1">Percentage</option>
                                        </select>
                                    </td>
                                    <td colspan="1">Discount Value</td>
                                    <td>
                                        <input type="number" name="customer_discount_val" oninput="totalamount(this)"
                                        id="customer_discount_value" value="0" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6"></td>
                                    <td>Discount</td>
                                    <td><span class="netdiscount">0</span></td>

                                </tr>
                                <tr>
                                    <td colspan="6"></td>
                                    <td>Net amount</td>
                                    <td><span class="nettotal">0</span></td>

                                </tr>
                                <tr>
                                    <td colspan="4"></td>
                                    <td>Bank Account</td>
                                    <td>
                                        <select name="bank_account_id" class="form-control banklist" required>
                                            <option value="">-SELECT-</option>
                                        </select>
                                    </td>
                                    <td>Paying Amount</td>
                                    <td colspan="2"><input type="number" id="amount" name="amount" min="0" class="form-control" required></td>

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


            {{--add customer--}}
            <form action="{{ route('admin.customer.store') }}" onsubmit="submitCustomer()" id="addBranchForm"
                  method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal fade" id="addCustomerModal">
                    <div class="modal-dialog modal-dialog-centered" role="document">
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
                                            <input type="text" class="form-control" id="first_name" name="first_name"
                                                   value="{{ old('first_name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="last_name" name="last_name"
                                                   value="{{ old('last_name') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Membership<span class="text-danger">*</span></label>
                                            <select name="customer_membership_id" id="customer_membership_id"
                                                    class="form-control" required>
                                                <option value="">-SELECT-</option>
                                                @foreach($memberships as $membership)
                                                    <option value="{{$membership->id}}">{{$membership->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Available Balance <span class="text-danger">*</span></label>
                                            <input type="number" id="available_balance" class="form-control"
                                                   name="available_balance" value="0" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                   value="{{ old('phone') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" class="form-control" id="email" name="email"
                                                   value="{{ old('email') }}">
                                        </div>
                                    </div>

                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>photo</label>
                                            <input type="file" class="form-control" id="photo" name="photo"
                                                   value="{{ old('photo') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>DOB</label>
                                            <input type="date" class="form-control" id="dob" name="dob"
                                                   value="{{ old('dob') }}">
                                        </div>
                                    </div>

                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select class="form-control" id="gender" name="gender"
                                                    value="{{ old('gender') }}">
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
                                            <select name="blood" id="blood" class="form-control default-select">
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
                                <div class="row mt-4">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea class="form-control" name="address" id="address" cols="30"
                                                      rows="10"></textarea>
                                        </div>
                                    </div>


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-rounded btn-dark" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="submit" class="btn rsbtn-1 color-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
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
                        <td class="selectDown">
                            <select name="service_id[]" class="form-control  product_select2"
                                    onchange="changeProduct(this)" required>
                                <option value="">-SELECT-</option>
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
                placeholder: "Service"
            });
        }
        $('.select2').select2();

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

            @if(!isAdmin())
                changedBranch({{ myBranchId() }});
            @else
                changedBranch(null);
            @endif


        });
        $(".banklist").select2();

        function changedBranch(branch_id) {
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
                    $(".banklist").html(res.bank_view);
                    console.log(res.bank_view);


                }
            });
        }

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
            $('#amount').val((total - discunt).toFixed(2));


        }

        $('#customer_select').on('change', function () {
            let isadd = $(this).find('option:selected').data('addcustomer');

            if (isadd) {
                $('#addCustomerModal').modal('show');
            }

        })

        function submitCustomer() {
            event.preventDefault()
            let first_name = $('#first_name').val()
            let last_name = $('#last_name').val()
            let customer_membership_id = $('#customer_membership_id').val()
            let available_balance = $('#available_balance').val()
            let phone = $('#phone').val()
            let email = $('#email').val()
            let photo = $('#photo').val()
            let dob = $('#dob').val()
            let gender = $('#gender').val()
            let blood = $('#blood').val()
            let address = $('#address').html()


            let route = "{{ route('admin.customer.ajaxadd') }}";
            let token = "{{ csrf_token()}}";
            $.ajax({
                url: route,
                type: 'POST',
                data: {
                    _token: token,
                    first_name: first_name,
                    last_name: last_name,
                    customer_membership_id: customer_membership_id,
                    available_balance: available_balance,
                    phone: phone,
                    email: email,
                    photo: photo,
                    dob: dob,
                    gender: gender,
                    blood: blood,
                    address: address,
                },
                success: function (response) {

                    $('#customer_select').html(response);
                    // changeCustomer($('#change_customer'));
                    $('#addCustomerModal').modal('hide');

                },
                error: function (xhr) {
                    //Do Something to handle error
                }
            });

        }


    </script>

@endsection
