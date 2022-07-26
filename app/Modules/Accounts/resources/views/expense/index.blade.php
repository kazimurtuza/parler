@extends('admin.layout.layout')

@section('main_content')
    <div class="row">
        <div class="col-12">
            @if($errors->any())
                <div class="alert alert-danger">
                    <p><strong>Opps Something went wrong</strong></p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
                <div class="col-md-7 d-flex align-items-start align-items-center">
                    @include('admin.partials._datatable_top_section', ['table_id' => 'responsive_datatable2'])
                </div>
                <div class="col-md-5 d-flex justify-content-end align-items-center">
                    <div>
                        <button class="btn btn-export" type="button" data-bs-toggle="modal"
                                data-bs-target="#addBranchModal">Add Expense
                        </button>
                    </div>

                </div>
            </div>

        </div>
        <div class="col-12">
            <div class="rs-table-wrapper">
                <table id="responsive_datatable2" class="w-100">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Branch</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Employee</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>
                            <i class="fa fa-cog"></i>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($expenses))
                        @foreach($expenses as $expense)
                            <tr>
                                <td class="table_sl">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="table_text">{{ $expense->branch->name }}</td>
                                <td class="table_text">{{ $expense->category->name }}</td>
                                <td class="table_text">{{ $expense->subcategory->name }}</td>
                                <td class="table_text">{{ $expense->employee->user->full_name }}</td>
                                <td class="table_number">{{ $expense->amount }}</td>
                                <td class="text-center">
                                    @if(Auth::user()->role == 'admin')
                                        @if($expense->status == 1)
                                            <span class="badge badge-lg light badge-success">Active</span>
                                        @else
                                            <span class="badge badge-lg light badge-danger">Inactive</span>
                                        @endif

                                    @elseif(Auth::user()->role == 'super_admin')
                                        <div class="btn-group mb-1">
                                            <button class="btn btn-{{ ($expense->status == 1)?'success':'danger' }} btn-xs rounded dropdown-toggle status-btn"
                                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                @if($expense->status == 1)
                                                    Active
                                                @else
                                                    Inactive
                                                @endif
                                            </button>
                                            <div class="dropdown-menu" style="margin: 0px;">
                                                <a class="dropdown-item" onclick="updateStatus(this)"
                                                   href="javascript:void(0)"
                                                   data-href="{{ route('admin.expense.update-status', ['id' => $expense->id, 'status' => 1]) }}">Active</a>
                                                <a class="dropdown-item" onclick="updateStatus(this)"
                                                   href="javascript:void(0)"
                                                   data-href="{{ route('admin.expense.update-status', ['id' => $expense->id, 'status' => 0]) }}">Inactive</a>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown ms-auto text-center">
                                        <div class="btn-link" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="javascript:void(0)"
                                               onclick="editBranch(this)"
                                               data-href="{{ route('admin.expense.edit',$expense->id) }}">Edit</a>
                                            {{--                                            <a class="dropdown-item" href="#">Delete</a>--}}
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
    <form action="{{ route('admin.expense.store') }}" id="addBranchForm" method="post">
        @csrf
        <div class="modal fade" id="addBranchModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Expense</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @if(isAdmin())
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Branch <span class="text-danger">*</span></label>
                                        <select name="branch_id" class="form-control select2" onchange="branchid(this.value)"
                                                id="branch_id" required>
                                            <option value="">-SELECT-</option>
                                            @foreach($branches as $branch)
                                                <option value="{{$branch->id}}" {{old('branch_id')==$branch->id?'selected':''}}>{{$branch->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Bank <span class="text-danger">*</span></label>
                                    <select name="bank_account_id" class="form-control select2"
                                            id="bankList" required>
                                        <option value="">-SELECT-</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Category <span class="text-danger">*</span></label>
                                    <select name="expense_category_id" class="form-control select2" id="category_id"
                                            onchange="categoryid(this)" required>
                                        <option value="">-SELECT-</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" {{old('expense_category_id')==$category->id?'selected':''}}>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Subcategory <span class="text-danger">*</span></label>
                                    <select name="expense_sub_category_id" id="subcategory_id"
                                            class="form-control subcategory_id select2"
                                            required>
                                        <option value="">-SELECT-</option>

                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Amount <span class="text-danger">*</span></label>
                                    <input type="number" name="amount" value="{{old('amount')}}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Date <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="datetime" value="{{old('datetime')}}"
                                           class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Employee <span class="text-danger">*</span></label>
                                    <select name="employee_id" class="form-control employee_id select2" id="employee_id"
                                            required>
                                        <option value="">-SELECT-</option>

                                    </select>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Note </label>
                                            <textarea name="note" class="form-control" id="" cols="30"
                                                      rows="10">{{old('note')}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-rounded btn-dark" data-bs-dismiss="modal">Close
                                </button>
                                <button type="submit" class="btn rsbtn-1 color-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="" id="editBranchForm" method="post">
        @csrf
        <div class="modal fade" id="editBranchModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Expense</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-rounded btn-dark" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn rsbtn-1 color-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('css_plugins')
    <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
    @include('admin.partials._datatable_css', ['with' => 'button'])
@endsection

@section('js_plugins')
    <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
    @include('admin.partials._datatable_js', ['with' => 'button'])
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('.select2').select2()
            var table2 = $('#responsive_datatable2').DataTable({
                dom: "<'row d-none'<'col-sm-12'Br>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                searching: true,
                paging: true,
                lengthChange: false,
                info: true,
                responsive: true,
                columnDefs: [
                    {responsivePriority: 1, targets: 0},
                    {responsivePriority: 2, targets: 1},
                    {responsivePriority: 4, targets: 5},
                    {responsivePriority: 3, targets: 6, orderable: false},
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
            });

            @if(!isAdmin())
                branchid({{myBranchId()}})
            @endif
        });

        function updateStatus(button) {
            let href = $(button).attr('data-href');
            let _token = "{{ csrf_token() }}";
            let req_data = {_token: _token};
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

        function editBranch(button) {
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
                }
            });
        }

        function branchid(branch_id) {

            // $('#branch_id').on('change', function () {

            let url = "{{route('Admin.EmployeeByBranch.get')}}"

            $.ajax({
                url: url,
                type: 'get',
                data: {
                    branch_id: branch_id
                },
                success: function (request) {
                    $('.employee_id').html(request[0]);
                    $('#employee_edit').html(request[0]);
                    $('#bankList').html(request[1]);
                },
                error: function (error) {

                }


            })

        }

        function categoryid(data) {
            // $('#category_id').on('change', function () {
            let category_id = $(data).val();
            let url = "{{route('Admin.subcategory.get')}}"

            $.ajax({
                url: url,
                type: 'get',
                data: {
                    category_id: category_id
                },
                success: function (request) {

                    $('.subcategory_id').html(request);
                    $('#subcategory_id_edit').html(request);
                },
                error: function (error) {

                }


            })

        }
    </script>

@endsection
