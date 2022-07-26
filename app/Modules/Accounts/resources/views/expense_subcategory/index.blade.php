@extends('admin.layout.layout')

@section('main_content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-7 d-flex align-items-start align-items-center">
                    @include('admin.partials._datatable_top_section', ['table_id' => 'responsive_datatable2'])
                </div>
                <div class="col-md-5 d-flex justify-content-end align-items-center">
                    <div> <button class="btn btn-export" type="button" data-bs-toggle="modal" data-bs-target="#addBranch_ServiceModal">Add Subcategory</button>
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
                        <th>Category Name</th>
                        <th>Subcategory Name</th>
                        <th>Status</th>
                        <th>
                            <i class="fa fa-cog"></i>
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @if(!empty($subcategories))
                        @foreach($subcategories as $subcategory)
                            <tr>
                                <td class="table_sl">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="table_text">{{ $subcategory->category->name }}</td>
                                <td class="table_text">{{ $subcategory->name }}</td>

                                <td class="text-center">


                                    <div class="btn-group mb-1">
                                        <button class="btn btn-{{ ($subcategory->status == 1)?'success':'danger' }} btn-xs rounded dropdown-toggle status-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            @if($subcategory->status == 1)
                                                Active
                                            @else
                                                Inactive
                                            @endif
                                        </button>
                                        <div class="dropdown-menu" style="margin: 0px;">
                                            <a class="dropdown-item" onclick="updateStatus(this)" href="javascript:void(0)" data-href="{{ route('admin.expenseSubcategory.update-status', ['id' => $subcategory->id, 'status' => 1]) }}">Active</a>
                                            <a class="dropdown-item" onclick="updateStatus(this)" href="javascript:void(0)" data-href="{{ route('admin.expenseSubcategory.update-status', ['id' => $subcategory->id, 'status' => 0]) }}">Inactive</a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown ms-auto text-center">
                                        <div class="btn-link" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="javascript:void(0)" onclick="editService(this)" data-href="{{ route('admin.expenseSubcategory.edit',$subcategory->id) }}">Edit</a>
                                            {{--<a class="dropdown-item" href="{{route('branch_service_delete',$service->id)}}">Delete</a>--}}
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
    <form action="{{ route('admin.expenseSubcategory.store') }}" id="addBranchForm" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="addBranch_ServiceModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Subcategory</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row mt-4">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label>Category</label>
                                    <select name="expense_category_id" id="discount_type" class="form-control" required>
                                        <option value="">-SELECT-</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" {{old('category_id')==$category->id?'selected':''}}>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}" required>
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
        </div>
    </form>

    <form action="" id="editServiceForm" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="editServiceModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Service</h5>
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
                    { responsivePriority: 4, targets: 3 },
                    { responsivePriority: 3, targets: 4, orderable: false },
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

        function editService(button) {
            // alert('sfds');
            // $("#editServiceModal").modal('show');
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
                    // console.log(response);
                    if (response.status == 200) {
                        $("#editServiceForm").attr('action', href);
                        $("#editServiceModal .modal-body").html(response.view);
                        $("#editServiceModal").modal('show');
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
        $('#service_id').on('change',function(){
            let price= $('option:selected',this).attr('data-price');
            let discount_val= $('option:selected',this).attr('data-discount-val');
            let dis_type= $('option:selected',this).attr('data-type');
            $('#discount_value').val(discount_val);
            $('#discount_type').val(dis_type);



            $('#price').val(price)
        })
    </script>

@endsection
