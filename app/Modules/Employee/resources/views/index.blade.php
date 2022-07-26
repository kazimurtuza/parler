@extends('admin.layout.layout')

@section('main_content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-7 d-flex align-items-start align-items-center">
                    @include('admin.partials._datatable_top_section', ['table_id' => 'responsive_datatable2'])
                </div>
                <div class="col-md-5 d-flex justify-content-end align-items-center">
                    <div>
                        <button class="btn deletebtn btn-export btn-export-danger" style="display: none"  onclick="BulkDelete()">
                            <i class="fas fa-trash fa-fw"></i> Delete
                        </button> &nbsp;
                    </div>
                    <div>
                        <button class="btn btn-export" type="button" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Add Employee</button>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-12">
            <div class="rs-table-wrapper">
                <table id="responsive_datatable2" class="w-100">
                    <thead>
                    <tr>

                        <th></th>
                        <th>SL</th>
                        <th style="max-width: 25%;" class="text-left">Employee</th>
                        <th>Branch Name</th>
                        <th>Salary Type</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>
                            <i class="fa fa-cog"></i>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($employees as $key=>$employee)
                        <tr>
                            <td class="table_sl">
                                <input class="form-check-input bulk_id slck" type="checkbox" name="employee_id[{{$employee->id}}]" value="{{ $employee->id }}">
                            </td>
                            <td class="table_sl">
                               {{$key+1}}
                            </td>
                            <td class="table_text">
                                <div class="table-user">
                                    <div class="tu-image">
                                        <img src="{{ $employee->default_photo }}" alt="{{ $employee->user->full_name }}">
                                    </div>
                                    <div class="tu-text">
                                        <div class="tu-title">
                                            <p>{{ $employee->user->full_name }}</p>
                                        </div>
                                        <div class="tu-subtitle">
                                            <p>{{ $employee->type }}</p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                {{$employee->branch->name}}
                            </td>
                            <td class="table_sl">{{$employee->salary_type_text}}</td>
                            <td class="text-center">{{$employee->user->phone}}</td>
                            <td class="text-center">
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="checkbox{{ $loop->iteration }}" onchange="updateStatus(this)" data-href="{{ route('admin.employee.update-status', ['id' => $employee->id, 'status' => '']) }}" {{ ($employee->status == 1)?'checked':'' }}>
                                    <label for="checkbox{{ $loop->iteration }}"></label>
                                </div>
                            </td>
                            <td>

                                <div class="dropdown ms-auto text-center">
                                    <div class="btn-link" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="detailsEmployee(this)" data-href="{{ route('admin.employee.details',$employee->id) }}">Details</a>
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="editEmployee(this)" data-href="{{ route('admin.employee.edit',$employee->id) }}">Edit</a>
                                        <a class="dropdown-item" href="{{url('Employee_Delete/'.$employee->id)}}">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>

                     @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('page_modals')
    <form action="{{ route('admin.employee.store') }}" id="addBranchForm" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="addEmployeeModal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="form-title-wrapper">
                                    <span class="emptitle">Basic information</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            @if(isAdmin())
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Branch <span class="text-danger">*</span></label>
                                        <select class="default-select form-control wide" name="branch_id" value="{{old('branch_id')}}" id="" required>
                                            <option value="">Select Branch</option>
                                            @foreach($branch as $branch_data)
                                                <option value="{{$branch_data->id}}" {{ (old('branch_id') == $branch_data->id)?'selected':'' }}>{{$branch_data->name}}</option>
                                            @endforeach

                                        </select>
                                        @if($errors->has('branch_id'))
                                            <span class="text-danger">{{ $errors->first('branch_id') }}</span>
                                        @endif

                                    </div>
                                </div>
                            @endif

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Employee Type <span class="text-danger">*</span></label>
                                    <select name="type" class="default-select form-control wide" id="emptype" required>
                                        <option value="">Select Employee Type</option>
                                        @if(isAdmin())
                                            <option value="manager" {{ (old('type') == 'manager')?'selected':'' }}>Manager</option>
                                        @endif
                                        <option value="storekeeper" {{ (old('type') == 'manager')?'selected':'' }}>Store Keeper</option>
                                        <option value="accountant" {{ (old('type') == 'manager')?'selected':'' }}>Accountant</option>
                                        <option value="staff" {{ (old('type') == 'manager')?'selected':'' }}>Staff</option>
                                    </select>

                                </div>
                                @if($errors->has('type'))
                                    <span class="text-danger">{{ $errors->first('type') }}</span>
                                @endif
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Joining Date <span class="text-danger">*</span></label>
                                    <input type="date" class="mdate form-control" value="{{old('joining_date')}}" name="joining_date" required placeholder="YYYY-MM-DD">
                                    @if($errors->has('joining_date'))
                                        <span class="text-danger">{{ $errors->first('joining_date') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="first_name" value="{{old('first_name')}}" required>
                                            @if($errors->has('first_name'))
                                                <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="last_name" value="{{old('last_name')}}" required>

                                            @if($errors->has('last_name'))
                                                <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>

                                            @if($errors->has('phone'))
                                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email </label>
                                            <input type="email" class="form-control" value="{{old('email')}}" name="email" >

                                            @if($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="form-group dropify-with-input mt-4">
                                    <label>Photo</label>
                                    <input type="file" name="photo" class="dropify form-control" data-height="120" accept="image/*">
                                    @if($errors->has('photo'))
                                        <span class="text-danger">{{ $errors->first('photo') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">

                            <div class="col-md-4">
                                <div class="form-group" id="password">
                                    <label>Password </label>
                                    <input  type="password" class="form-control" value="{{old('password')}}" name="password" >

                                    @if($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Salary Type <span class="text-danger">*</span></label>
                                    <select  class="default-select form-control wide" name="salary_type" value="{{old('salary_type')}}" id="" required>

                                        <option value="">Select Salary Type</option>
                                        <option value="0">Commission Based</option>
                                        <option value="1">Salary Based</option>
                                    </select>
                                    @if($errors->has('salary_type'))
                                        <span class="text-danger">{{ $errors->first('salary_type') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Salary value <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="salary_value" value="{{old('salary_value')}}" required>
                                    @if($errors->has('salary_value'))
                                        <span class="text-danger">{{ $errors->first('salary_value') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4 mt-5">
                            <div class="col-12">
                                <div class="form-title-wrapper">
                                    <span class="emptitle">Other Info</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Gender <span class="text-danger">*</span></label>
                                    <select name="gender" id="" class="default-select form-control wide" required>
                                        <option value="">Select Gender</option>
                                        <option value="0">Male</option>
                                        <option value="1">Female</option>
                                        <option value="2">Others</option>
                                    </select>
                                    @if($errors->has('gender'))
                                        <span class="text-danger">{{ $errors->first('gender') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Marital Status</label>
                                    <select name="marital_status" id="" class="default-select form-control wide">
                                        <option value="">Select Marital Status</option>
                                        <option value="1">Married</option>
                                        <option value="0">Unmarried</option>
                                    </select>
                                    @if($errors->has('marital_status'))
                                        <span class="text-danger">{{ $errors->first('marital_status') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
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
                                    @if($errors->has('blood'))
                                        <span class="text-danger">{{ $errors->first('blood') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <input type="date" name="dob" value="{{old('dob')}}" class="mdate form-control" placeholder="YYYY-MM-DD">
                                    @if($errors->has('dob'))
                                        <span class="text-danger">{{ $errors->first('dob') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nid No</label>
                                    <input type="text" name="nid_number" value="{{old('nid_number')}}" class="form-control">
                                    @if($errors->has('nid_number'))
                                        <span class="text-danger">{{ $errors->first('nid_number') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Present Address</label>
                                    <textarea  class="form-control h-80px" rows="10" name="address">{{old('address')}}</textarea>

                                    @if($errors->has('address'))
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Permanent Address</label>
                                    <textarea  class="form-control h-80px" rows="10" name="permanent_address">{{old('permanent_address')}}</textarea>
                                    @if($errors->has('permanent_address'))
                                        <span class="text-danger">{{ $errors->first('permanent_address') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contact Person Name</label>
                                    <input type="text" name="contact_person_name" value="{{old('contact_person_name')}}" class="form-control">
                                    @if($errors->has('contact_person_name'))
                                        <span class="text-danger">{{ $errors->first('contact_person_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contact Person number</label>
                                    <input type="text" name="contact_person_number" value="{{old('contact_person_number')}}" class="form-control">
                                    @if($errors->has('contact_person_number'))
                                        <span class="text-danger">{{ $errors->first('contact_person_number') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>



                        {{-------------------------------------------------------}}



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-rounded btn-dark" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn rsbtn-1 color-primary" >Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="" id="editBranchForm" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="editBranchModal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Employee</h5>
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

        <div class="modal fade" id="detailModal">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Employee Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                    </div>
                </div>
            </div>
        </div>

@endsection

@section('css_plugins')
    <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
    @include('admin.partials._datatable_css', ['with' => 'button'])
    @include('admin.partials._mdatepicker_css')
    @include('admin.partials._dropify_css')
@endsection

@section('js_plugins')
    <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
    @include('admin.partials._datatable_js', ['with' => 'button'])
    @include('admin.partials._mdatepicker_js')
    @include('admin.partials._dropify_js')
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('.select2').select2()

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
                    { responsivePriority: 2, targets: 2 },
                    { responsivePriority: 4, targets: 1 },
                    { responsivePriority: 5, targets: 4 },
                    { responsivePriority: 6, targets: 3 },
                    { responsivePriority: 6, targets: 6 },
                    { responsivePriority: 3, targets: 7, orderable: false },
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

        function editEmployee(button) {
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
                        $("#editBranchForm").attr('action', href);
                        $("#editBranchModal .modal-body").html(response.view);
                        $("#editBranchModal").modal('show');
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
                    if(jQuery('.default-select').length > 0 ){
                        jQuery('.default-select').niceSelect('update');
                    }
                    $(".mdate").bootstrapMaterialDatePicker({
                        weekStart: 0,
                        time: false,
                        format: 'YYYY-MM-DD'
                    });
                    $('.dropify').dropify();
                }
            });
        }

        function detailsEmployee(button) {
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

                        $("#detailModal .modal-body").html(response.view);
                        $("#detailModal").modal('show');
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

            let route = "{{ route('admin.employeeBulk.delete') }}";
            let token = "{{ csrf_token()}}";
            $.ajax({
                url: route,
                type: 'get',
                data: {
                    _token:token,
                    ids:bulk_ids,
                },
                success: function(response) {
                    showSuccessAlert('Invalid!', 'Successfully Deleted services');
                    window.location.href = window.location.href;

                },
                error: function(xhr) {
                    //Do Something to handle error
                }});


        }
        $('#emptype').on('change',function(){
            if($(this).val()==='staff'){
                $('#password').hide();
            }else{
                $('#password').show();
            }


        })

    </script>

@endsection
