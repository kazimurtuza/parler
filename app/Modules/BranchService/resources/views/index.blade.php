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
                        <button class="btn btn-export" type="button" data-bs-toggle="modal" data-bs-target="#addBranch_ServiceModal">Add Service</button>

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
                        <th class="text-left">Branch</th>
                        <th>Service</th>
                        <th>Discount Type</th>
                        <th>Discount Value</th>
                        <th>Status</th>
                        <th>
                            <i class="fa fa-cog"></i>
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @if(!empty($branch_services))
                        @foreach($branch_services as $service)
                            <tr>
                                <td class="table_sl">
                                    <input class="form-check-input slck bulk_id" type="checkbox" name="service_id[{{$service->id}}]" value="{{ $service->id }}" id="flexCheckDefault"> &nbsp;
                                </td>
                                <td class="table_sl">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="text-left">{{ $service->branch->name }}</td>
                                <td class="text-center">
                                    <div class="table-user">
                                        <div class="tu-image">
                                            <img src="{{ $service->service->default_image }}" alt="{{ $service->service->name }}">
                                        </div>
                                        <div class="tu-text">
                                            <div class="tu-title">
                                                <p style="font-size: 13px;color:#000;font-weight:500;">{{ $service->service->name }}</p>
                                            </div>
                                            <div class="tu-subtitle">
                                                <p style="font-size: 14px;font-weight: 600;color:var(--primary);margin-top:3px;">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }} {{ $service->service->price }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{ $service->discount_type_text }}</td>
                                <td class="text-center">{{ $service->discount_value }}</td>
                                <td class="text-center">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" id="checkbox{{ $loop->iteration }}" onchange="updateStatus(this)" data-href="{{ route('admin.branch_service.update-status', ['id' => $service->id, 'status' => '']) }}" {{ ($service->status == 1)?'checked':'' }}>
                                        <label for="checkbox{{ $loop->iteration }}"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown ms-auto text-center">
                                        <div class="btn-link" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="javascript:void(0)" onclick="editService(this)" data-href="{{ route('admin.branch_service.edit',$service->id) }}">Edit</a>
                                            <a class="dropdown-item" href="{{route('branch_service_delete',$service->id)}}">Delete</a>
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
    <form action="{{ route('admin.branch_service.store') }}" id="addBranchForm" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="addBranch_ServiceModal">
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
                            @if(isAdmin())
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Branch <span class="text-danger">*</span></label>
                                    <select name="branch_id" class="default-select form-control wide branch" id="branch_id" onchange="branchSelect(this.value)" required>
                                        <option value="">Select Branch</option>
                                        @foreach($branches as $branch)
                                            <option value="{{$branch->id}}">{{$branch->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Service <span class="text-danger">*</span></label>
                                    <select name="service_id"  class="default-select form-control wide service_id_cls" id="service_id" onchange="serviceChange(this)" required>
                                        <option value="">Select Service</option>
                                        {{--@foreach($services as $service)
                                            <option value="{{$service->id}}" data-price="{{$service->price}}" data-type="{{$service->discount_type}}" data-discount-val="{{$service->discount_value}}">{{$service->name}}</option>
                                        @endforeach--}}
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Price <span class="text-danger">*</span></label>
                                    <input type="number" id="price" class="form-control" name="price" value="{{ old('price') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Discount Type</label>
                                    <select name="discount_type" id="discount_type_data" class="default-select form-control wide" required>
                                        <option value="">Select Discount Type</option>
                                        <option value="0">Fixed</option>
                                        <option value="1">Percentage</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Discount Value <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control"  name="discount_value" id="discount_value" value="{{ old('discount_value') }}" required>
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
    <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
@endsection

@section('js_plugins')
    <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>

    @include('admin.partials._datatable_js', ['with' => 'button'])
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            @if(!isAdmin())
                branchSelect({{ myBranchId() }});
            @endif
            // $('.branch').select2()
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
                    { responsivePriority: 3, targets: 7, orderable: false },
                    { responsivePriority: 4, targets: 2 },
                    { responsivePriority: 4, targets: 6 },
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
                    jQuery('#editServiceModal .default-select').niceSelect();
                }
            });
        }
        // $('#service_id').on('change',function(){
        //     let price= $('option:selected',this).attr('data-price');
        //     let discount_val= $('option:selected',this).attr('data-discount-val');
        //     let dis_type= $('option:selected',this).attr('data-type');
        //     $('#discount_value').val(discount_val);
        //     $('#discount_type').val(dis_type);
        //
        //
        //
        //     $('#price').val(price)
        // })

       function serviceChange(data){
           let price= $('option:selected',data).attr('data-price');
           let discount_val= $('option:selected',data).attr('data-discount-val');
           let dis_type= $('option:selected',data).attr('data-type');
           $('#discount_value').val(discount_val);
           $('#discount_type_data').val(dis_type);
           $('#price').val(price)
           $('.price').val(price);
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

            let route = "{{ route('admin.branch-serviceBulk.delete') }}";
            let token = "{{ csrf_token()}}";
            $.ajax({
                url: route,
                type: 'get',
                data: {
                    _token:token,
                    ids:bulk_ids,
                },
                success: function(response) {
                    showSuccessAlert('Service!', 'Successfully  services Deleted');
                    window.location.href = window.location.href;

                },
                error: function(xhr) {
                    //Do Something to handle error
                }});


        }
        // $('.service_id_cls').select2()
        function branchSelect(branchId){
            let route = "{{ route('admin.branch-services.list') }}";
            let token = "{{ csrf_token()}}";
            $.ajax({
                url: route,
                type: 'get',
                data: {
                    _token:token,
                    id:branchId,
                },
                success: function(response) {
                    $('.service_id_cls').html(response);
                    // console.log(response);
                    // $('.service_id_cls').select2()
                    jQuery('.default-select').niceSelect('update');
                },
                error: function(xhr) {
                    //Do Something to handle error
                }});


        }


    </script>

@endsection
