@extends('admin.layout.layout')

@section('main_content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-7 d-flex align-items-start align-items-center">
                    @include('admin.partials._datatable_top_section', ['table_id' => 'responsive_datatable2', 'import_button' => 'show'])
                </div>
                <div class="col-md-5 d-flex justify-content-end">
                    <div>
                        <button class="btn deletebtn btn-export btn-export-danger" style="display: none;" onclick="BulkDelete()">
                            <i class="fas fa-trash fa-fw"></i> Delete
                        </button> &nbsp;
                    </div>
                    <div>
                        <button class="btn btn-export" type="button" data-bs-toggle="modal"
                                data-bs-target="#addServiceModal">Add Service
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
                        <th></th>
                        <th>SL</th>
                        <th class="text-left" style="width: 25%;">Service</thcl>
                        <th class="text-left" style="width: 20%;">Description</th>
                        <th>Discount Type</th>
                        <th>Discount Value</th>
                        <th>Status</th>
                        <th>
                            <i class="fa fa-cog"></i>
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @if(!empty($services))
                        @foreach($services as $service)
                            <tr>
                                <td>
                                    <input class="form-check-input slck bulk_id" type="checkbox"
                                           name="service_id[{{$service->id}}]" value="{{ $service->id }}"
                                           id="flexCheckDefault">
                                </td>

                                <td class="table_sl">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="table_text">
                                    <div class="table-user">
                                        <div class="tu-image">
                                            <img src="{{ $service->default_image }}" alt="{{ $service->name }}">
                                        </div>
                                        <div class="tu-text">
                                            <div class="tu-title">
                                                <p style="font-size: 13px;color:#000;font-weight:500;">{{ $service->name }}</p>
                                            </div>
                                            <div class="tu-subtitle">
                                                <p style="font-size: 14px;font-weight: 600;color:var(--primary);margin-top:3px;">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }} {{ $service->price }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="table_text " style="text-align: justify;">
                                    <div class="data-ccollapse-wrapper">
                                        <div class="data-ccollapse" id="ccollapse{{ $loop->iteration }}"
                                             data-max-height="44">
                                            <p>{{ $service->description }}</p>
                                        </div>
                                        @if(strlen($service->description) > 200)
                                            <a href="javascript:void(0)" class="site-btn mt-20 ccollapse-btn text-primary"
                                               data-ccollapse-section="#ccollapse{{ $loop->iteration }}">
                                                View More
                                            </a>
                                        @endif
                                    </div>
                                </td>

                                <td class="text-center">{{ $service->discount_type_text }}</td>
                                <td class="text-center">
                                    <b>{{ $service->discount_value }}</b>
                                </td>
                                <td class="text-center">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" id="checkbox{{ $loop->iteration }}" onchange="updateStatus(this)" data-href="{{ route('admin.service.update-status', ['id' => $service->id, 'status' => '']) }}" {{ ($service->status == 1)?'checked':'' }}>
                                        <label for="checkbox{{ $loop->iteration }}"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown ms-auto text-center">
                                        <div class="btn-link" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="javascript:void(0)"
                                               onclick="editService(this)"
                                               data-href="{{ route('admin.service.edit',$service->id) }}">Edit</a>
                                            @if(checkUserRole('admin'))
                                                <a class="dropdown-item"
                                                   href="{{route('service_delete',$service->id)}}">Delete</a>
                                            @endif
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
    <form action="{{ route('admin.service.store') }}" id="addBranchForm" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="addServiceModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                           required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Price <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="price" value="{{ old('price') }}"
                                           required>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Discount Type </label>
                                    <select name="discount_type" class="default-select form-control wide" required>
                                        <option value="0">Fixed</option>
                                        <option value="1">Percentage</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Discount Value </label>
                                    <input type="number" class="form-control" min="0" name="discount_value" value="0">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" class="dropify form-control" name="image" data-height="100" accept="image/*">
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
                        <button type="submit" class="btn rsbtn-1 color-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <form action="{{route('admin.service.import')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="productImport" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group import-file-wrapper">
                                    <label>Import File <span class="text-danger">*</span></label>
                                    <input type="file" class="dropify form-control" name="import_file" value="" required data-height="120">
                                    <h6 class="text-center mt-2">**File Format must be Excel**</h6>
                                    <br>
                                    <h6 class="text-center"><a href="{{asset('demo-excel/service-list-demo.xlsx')}}" download> Download Demo File</a></h6>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
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
    <script src="{{ asset('assets/backend/js/view_more_less.js') }}"></script>
    @include('admin.partials._dropify_js')
@endsection

@section('js')
    <script>
        $(document).ready(function () {
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

        function editService(button) {
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
                        $("#editServiceForm").attr('action', href);
                        $("#editServiceForm .modal-body").html(response.view);
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
                    if(jQuery('.default-select').length > 0 ){
                        jQuery('.default-select').niceSelect('update');
                    }
                    $('.dropify').dropify();
                }
            });
        }

        $('.slck').on('click', function () {
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

            let route = "{{ route('admin.bulkDelete.delete') }}";
            let token = "{{ csrf_token()}}";
            $.ajax({
                url: route,
                type: 'get',
                data: {
                    _token: token,
                    ids: bulk_ids,
                },
                success: function (response) {
                    showSuccessAlert('Invalid!', 'Successfully Deleted services');
                    console.log(response)
                    window.location.href = window.location.href;

                },
                error: function (xhr) {
                    //Do Something to handle error
                }
            });
        }

        $('.xlimport').on('click', function () {
            $('#productImport').modal('show');
        })
    </script>

@endsection
