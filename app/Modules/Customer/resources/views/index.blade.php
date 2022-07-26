@extends('admin.layout.layout')

@section('main_content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-7 d-flex align-items-start align-items-center">
                    @include('admin.partials._datatable_top_section', ['table_id' => 'responsive_datatable2'])
                </div>
                <div class="col-md-5 d-flex justify-content-end align-items-center">
                    <div><button class="btn deletebtn btn-export btn-export-danger" style="display: none"  onclick="BulkDelete()"><i class="fas fa-trash fa-fw"></i></button></div>
                    <div>
                        <button class="btn btn-export" type="button" data-bs-toggle="modal" data-bs-target="#addCustomerModal">Add Customer</button>
                    </div>

                </div>
            </div>

        </div>
        <div class="col-12">
            <div class="rs-table-wrapper">
                <table id="responsive_datatable2" class="w-100">
                    <thead>
                    <tr>
                        <th class="siWidth" ></th>
                        <th class="siWidth" >SL</th>
                        <th class="text-left" style="width: 35%;">Customer</th>
                        <th>Membership</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Balance</th>
                        <th>Status</th>
                        <th>
                            <i class="fa fa-cog"></i>
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @if(!empty($customers))
                        @foreach($customers as $customer)
                            <tr>
                                <td class="table_sl">
                                    <input class="form-check-input slck bulk_id " type="checkbox" name="customer_id[{{$customer->id}}]" value="{{ $customer->id }}" id="flexCheckDefault">
                                </td>
                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="table_text">
                                    <div class="table-user">
                                        <div class="tu-image">
                                            <img src="{{ asset($customer->default_photo) }}" alt="{{ $customer->full_name }}">
                                        </div>
                                        <div class="tu-text">
                                            <div class="tu-title">
                                                <p>{{ $customer->full_name }}</p>
                                            </div>
                                            <div class="tu-subtitle">
                                                <p class="font-10">{{ $customer->address }}</p>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                                {{--<td>{{ $customer->branch->name }}</td>--}}
                                <td class="text-center"><b>{{ $customer->membership->title }}</b></td>
                                <td class="text-center">{{ $customer->email }}</td>
                                <td class="text-center">{{ $customer->phone }}</td>
                                <td class="text-center">
                                    <span style="font-weight: 600;">{{ $customer->available_balance }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" id="checkbox{{ $loop->iteration }}" onchange="updateStatus(this)" data-href="{{ route('admin.customer.update-status', ['id' => $customer->id, 'status' => '']) }}" {{ ($customer->status == 1)?'checked':'' }}>
                                        <label for="checkbox{{ $loop->iteration }}"></label>
                                    </div>
                                </td>
                                <td class="table_sl">
                                    <div class="dropdown ms-auto text-center">
                                        <div class="btn-link" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="javascript:void(0)" onclick="editCustomer(this)" data-href="{{ route('admin.customer.edit',$customer->id) }}">Edit</a>
                                                                                        <a class="dropdown-item" href="{{route('customer_delete',$customer->id)}}">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('page_modals')
    <form action="{{ route('admin.customer.store') }}" id="addBranchForm" method="post" enctype="multipart/form-data">
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
                        <div class="row ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="email" value="{{ old('email') }}" >
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>DOB</label>
                                    <input type="date" class="mdate form-control" name="dob" value="{{ old('dob') }}" >
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Membership<span class="text-danger">*</span></label>
                                    <select name="customer_membership_id" class="default-select form-control wide" required >
                                        <option value="">Select Membership</option>
                                        @foreach($memberships as $membership)
                                        <option value="{{$membership->id}}">{{$membership->title}}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Available Balance <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control"  name="available_balance" value="0" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select class="default-select form-control wide" name="gender" value="{{ old('gender') }}">
                                        <option value="">Select Gender</option>
                                        <option value="0">Male</option>
                                        <option value="1">Female</option>
                                        <option value="2">Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Blood Group</label>
                                    <select name="blood" class="default-select form-control wide">
                                        <option value="">Select Blood Group</option>
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
                                    <textarea class="form-control" name="address"  cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Photo</label>
                                    <input type="file" class="dropify form-control" name="photo" value="" data-height="100">
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

    <form action="" id="editCustomerForm" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="editCustomerModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-rounded btn-dark" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn rsbtn-1 color-primary" >Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('css_plugins')
    @include('admin.partials._datatable_css', ['with' => 'button'])
    @include('admin.partials._mdatepicker_css')
    @include('admin.partials._dropify_css')
@endsection

@section('js_plugins')
    @include('admin.partials._datatable_js', ['with' => 'button'])
    @include('admin.partials._mdatepicker_js')
    @include('admin.partials._dropify_js')
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            var table2 = $('#responsive_datatable2').DataTable( {
                dom: "<'row d-none'<'col-sm-12'Br>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                searching:true,
                paging:true,
                lengthChange:false,
                info:true,
                responsive: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: 1 },
                    { responsivePriority: 3, targets: 8, orderable: false },
                    { responsivePriority: 4, targets: 2 },
                    { responsivePriority: 5, targets: 7, orderable: false },
                ],
                language: {
                    paginate: {
                        next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                        previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                    }
                },
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            } );
        });

        function updateStatus(button) {
            let href = $(button).attr('data-href');
            let _token = "{{ csrf_token() }}";
            let req_data = {_token: _token};
            if ($(button).is(":checked")) {
                href = href + "/1";
            } else {
                href = href + "/0";
            }
            $.ajax({
                type: 'POST',
                url: href,
                data: req_data,
                beforeSend: function () {
                    showLoader('Loading...', 'Please Wait');
                },
                success: function (response) {
                    if (response.status == 200) {
                        if (response.updated_status == 1) {
                            $(button).parent().parent().find('.status-btn').html('Active').removeClass('btn-danger').addClass('btn-success');
                        } else {
                            $(button).parent().parent().find('.status-btn').html('Inactive').removeClass('btn-success').addClass('btn-danger');
                        }
                        hideLoader();
                    } else {
                        hideLoader();
                        showErrorAlert('Error!', response.msg);
                    }
                },
                error: function (err) {
                    showHttpErrorAlert(err);
                },
                complete: function () {
                }
            });
        }

        function editCustomer(button) {
            let href = $(button).attr('data-href');
            let _token = "{{ csrf_token() }}";
            let req_data = {_token: _token};
            $.ajax({
                type: 'GET',
                url: href,
                data: req_data,
                beforeSend: function () {
                    showLoader('Loading...', 'Please Wait');
                },
                success: function (response) {
                    if (response.status == 200) {
                        $("#editCustomerForm").attr('action', href);
                        $("#editCustomerForm .modal-body").html(response.view);
                        $("#editCustomerModal").modal('show');
                        hideLoader();
                    } else {
                        hideLoader();
                        showErrorAlert('Error!', response.msg);
                    }
                },
                error: function (err) {
                    showHttpErrorAlert(err);
                },
                complete: function () {
                    $(".mdate").bootstrapMaterialDatePicker({
                        weekStart: 0,
                        time: false,
                        format: 'YYYY-MM-DD'
                    });
                    if(jQuery('.default-select').length > 0 ){
                        jQuery('.default-select').niceSelect('update');
                    }
                    $('.dropify').dropify();
                }
            });
        }


        $('.slck').on('click',function(){
            let checked_num = $('.bulk_id:checkbox:checked').length;
            if (checked_num > 0) {
                $('.deletebtn').show();
            } else {
                $('.deletebtn').hide();
            }
        });


        function BulkDelete() {
            var bulk_ids = [];
            $('.bulk_id:checkbox:checked').each(function () {
                let checkbox = this;
                bulk_ids.push($(checkbox).val());
            });
            if (bulk_ids.length <= 0) {
                showErrorAlert('Invalid!', 'Please select at least 1 element to delete');
                return false;
            }

            let route = "{{ route('admin.customerBulk.delete') }}";
            let token = "{{ csrf_token()}}";
            $.ajax({
                url: route,
                type: 'get',
                data: {
                    _token:token,
                    ids:bulk_ids,
                },
                success: function(response) {
                    showSuccessAlert('Success!', 'Successfully Deleted Customers');
                    window.location.href = window.location.href;

                },
                error: function(xhr) {
                    showErrorAlert('Invalid!', 'Error Found');
                }});


        }

    </script>

@endsection
