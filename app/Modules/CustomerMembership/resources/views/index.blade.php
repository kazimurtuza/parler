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
                        <button class="btn-export" type="button" data-bs-toggle="modal" data-bs-target="#addMemberModal">Add Membership</button>
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
                        <th>Icon</th>
                        <th class="text-left">Title</th>
                        <th>Discount Type</th>
                        <th>Discount value</th>
                        <th>Status</th>
                        <th>
                            <i class="fa fa-cog"></i>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($memberships as $key => $membership)
                        <tr>
                            <td class="table_sl">{{$key+1}}</td>
                            <td class="table_sl">
                                <img src="{{asset($membership->default_icon)}}" width="50px" height="50px" alt="no image">
                            </td>
                            <td class="table_text">{{$membership->title}}</td>
                            <td class="text-center">{{$membership->discount_type_text}}</td>
                            <td class="text-center"><b>{{$membership->discount_value}}</b></td>
                            <td class="text-center">
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="checkbox{{ $loop->iteration }}" onchange="updateStatus(this)" data-href="{{ route('admin.membership.update-status', ['id' => $membership->id, 'status' => '']) }}" {{ ($membership->status == 1)?'checked':'' }}>
                                    <label for="checkbox{{ $loop->iteration }}"></label>
                                </div>
                            </td>

                            <td>
                                <div class="dropdown ms-auto text-center">
                                    <div class="btn-link" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="javascript:void(0)" onclick="editMembership(this)" data-href="{{ route('admin.membership.edit',$membership->id) }}">Edit</a>
                                        <a class="dropdown-item" href="{{url('Membership_Delete/'.$membership->id)}}">Delete</a>
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
    <form action="{{ route('admin.customermember.store') }}" id="addBranchForm" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="addMemberModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Membership</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Membership Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title" value="{{ old('name') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Discount Type <span class="text-danger ">*</span></label>
                                    <select name="discount_type" class="default-select form-control wide" required>
                                        <option value="">Select Discount Type</option>
                                        <option value="0">Fixed</option>
                                        <option value="1">percentage</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Discount Value <span class="text-danger">*</span></label>
                                    <input type="number" step="any" class="form-control" name="discount_value" value="{{ old('discount_value') }}" required>

                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Icon</label>
                                    <input type="file" class="form-control dropify" name="icon"  data-height="120">
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

    <form action="" id="editMembershipForm" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="editMembershipModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Membership</h5>
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
    @include('admin.partials._dropify_css')
@endsection

@section('js_plugins')
    @include('admin.partials._datatable_js', ['with' => 'button'])
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
                    { responsivePriority: 2, targets: 2 },
                    { responsivePriority: 4, targets: 1 },
                    { responsivePriority: 5, targets: 5 },
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

        function editMembership(button) {
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
                        $("#editMembershipForm").attr('action', href);
                        $("#editMembershipModal .modal-body").html(response.view);
                        $("#editMembershipModal").modal('show');
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
                    $('.dropify').dropify();
                    if(jQuery('.default-select').length > 0 ){
                        jQuery('.default-select').niceSelect('update');
                    }
                }
            });
        }
    </script>

@endsection
