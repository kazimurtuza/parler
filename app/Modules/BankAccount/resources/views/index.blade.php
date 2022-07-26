@extends('admin.layout.layout')

@section('main_content')
<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-md-7 d-flex align-items-start align-items-center">
                @include('admin.partials._datatable_top_section', ['table_id' => 'responsive_datatable2'])
            </div>
            <div class="col-md-5 d-flex justify-content-end">
                <div>
                    <button class="btn btn-export" type="button" data-bs-toggle="modal" data-bs-target="#addBranchModal"><i class="fa fa-plus"></i>&nbsp; New Bank Account</button>
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
                    <th>Name</th>
                    <th>Account No</th>
                    <th>Opening Balance</th>
                    {{--<th>Status</th>--}}
                    <th>
                        <i class="fa fa-cog"></i>
                    </th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($bankAccounts))
                @foreach($bankAccounts as $account)
                <tr>
                    <td class="table_sl">
                        {{ $loop->iteration }}
                    </td>
                    <td class="table_text">{{ $account->branch->name }}</td>
                    <td class="table_text">{{ $account->name }}</td>
                    <td class="table_text">#{{ $account->account_no }}</td>
                    <td class="table_number">{{ $account->opening_balance }}</td>

                    <td>
                        <div class="dropdown action-dropdown ms-auto text-center">
                            <div class="btn-link" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </div>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="javascript:void(0)" onclick="editBranch(this)" data-href="{{ route('admin.account-balance.edit',$account->id) }}">Edit</a>
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
<form action="{{ route('admin.bank-account.store') }}" id="addBranchForm" method="post">
    @csrf
    <div class="modal fade" id="addBranchModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    @if(isAdmin())
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Branch <span class="text-danger">*</span></label>
                                    <select name="branch_id" class="form-control select2" id="" required>
                                        <option value="">-SELECT-</option>
                                        @foreach($branches as $branch)
                                        <option value="{{$branch->id}}">{{$branch->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <div class="form-group">
                                <label>Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Account No <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="account_no" value="{{ old('account_no') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Opening Balance</label>
                                <input type="number"  class="form-control" min="0" name="opening_balance" value="0" >
                            </div>
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
</form>

<form action="" id="editBranchForm" method="post">
    @csrf
    <div class="modal fade" id="editBranchModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Account</h5>
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
                { responsivePriority: 4, targets: 2 },
                { responsivePriority: 3, targets: 5, orderable: false },
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
    $('.select2').select2();

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
</script>

@endsection
