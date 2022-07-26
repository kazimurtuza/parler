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
                        <button class=" btn-export" type="button" data-bs-toggle="modal" data-bs-target="#addBranchModal"><i class="fa fa-plus"></i>&nbsp; New Branch</button>
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
                        <th style="width: 20%;text-align: left;">Branch Name</th>
                        <th style="width: 15%;">Phone</th>
                        <th class="text-left">Address</th>
                        <th>Note</th>
                        <th>Status</th>
                        <th>
                            <i class="fa fa-cog"></i>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($branches))
                        @foreach($branches as $branch)
                            <tr>
                                <td class="table_sl">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="table_text">{{ $branch->name }}</td>
                                <td class="text-center">{{ $branch->contact_phone }}</td>
                                <td class="table_text">{{ $branch->address }}</td>
                                <td class="table_text">{{ $branch->note }}</td>
                                <td class="text-center">
                                    @if(Auth::user()->role == 'admin')
                                        @if($branch->status == 1)
                                            <span class="badge badge-lg light badge-success">Active</span>
                                        @else
                                            <span class="badge badge-lg light badge-danger">Inactive</span>
                                        @endif

                                    @elseif(Auth::user()->role == 'super_admin')
                                        <div class="custom-checkbox">
                                            <input type="checkbox" id="checkbox{{ $loop->iteration }}" onchange="updateStatus(this)" data-href="{{ route('admin.branch.update-status', ['id' => $branch->id, 'status' => '']) }}" {{ ($branch->status == 1)?'checked':'' }}>
                                            <label for="checkbox{{ $loop->iteration }}"></label>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown ms-auto text-center">
                                        <div class="btn-link" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="javascript:void(0)" onclick="editBranch(this)" data-href="{{ route('admin.branch.edit',$branch->id) }}">Edit</a>
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
    <form action="{{ route('admin.branch.store') }}" id="addBranchForm" method="post">
        @csrf
        <div class="modal fade" id="addBranchModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Branch</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Branch Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Phone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="address" value="{{ old('address') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Note </label>
                                    <textarea name="note" class="form-control" rows="4"></textarea>
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
                        <h5 class="modal-title">Edit Branch</h5>
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
@endsection

@section('js_plugins')
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
                    { responsivePriority: 3, targets: 6, orderable: false },
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
