@extends('admin.layout.layout')

@section('main_content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                {{--<div class="col-md-7 d-flex align-items-start align-items-center">--}}
                    {{--<div>  <button class="btn btn-export xlimport"><i class="fa fa-upload"></i> Import</button></div>--}}
                    {{--@include('admin.partials._datatable_top_section', ['table_id' => 'responsive_datatable2'])--}}

                {{--</div>--}}

                <div class="col-md-7 d-flex align-items-start align-items-center">
                    @include('admin.partials._datatable_top_section', ['table_id' => 'responsive_datatable2', 'import_button' => 'show'])
                </div>
                <div class="col-md-5 d-flex justify-content-end">
                    <div><button class="btn btn-export deletebtn" style="display: none" onclick="BulkDelete()"><i class="fas fa-trash fa-fw"></i></button>
                    </div>
                    <div>
                        <button class="btn btn-export" type="button" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product</button>
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
                        <th class="text-left">Name</th>
                        <th class="text-left">Note</th>
                        <th>Status</th>
                        <th>
                            <i class="fa fa-cog"></i>
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @if(!empty($products))
                        @foreach($products as $product)
                            <tr>
                                <td class="table_sl">  <input class="form-check-input slck bulk_id" type="checkbox" name="employee_id[{{$product->id}}]" value="{{ $product->id }}" id="flexCheckDefault"> &nbsp;</td>
                                <td class="table_sl">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="table_text">
                                    <div class="table-user">
                                        <div class="tu-image">
                                            <img src="{{ $product->default_image }}" alt="{{ $product->name }}">
                                        </div>
                                        <div class="tu-text">
                                            <div class="tu-title">
                                                <p style="font-size: 13px;color:#000;font-weight:500;">{{ $product->name }}</p>
                                            </div>
                                            <div class="tu-subtitle">
                                                <p style="font-size: 14px;font-weight: 600;color:var(--primary);margin-top:3px;">{{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }} {{ $product->price }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="table_text">{{ $product->note }}</td>
                                <td class="text-center">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" id="checkbox{{ $loop->iteration }}" onchange="updateStatus(this)" data-href="{{ route('admin.product.update-status', ['id' => $product->id, 'status' => '']) }}" {{ ($product->status == 1)?'checked':'' }}>
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
                                               data-href="{{ route('admin.product.edit',$product->id) }}">Edit</a>
                                            <a class="dropdown-item" href="{{route('product_delete',$product->id)}}">Delete</a>
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
    <form action="{{ route('admin.product.store') }}" id="addBranchForm" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="addProductModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Product</h5>
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
                                    <label>Note</label>
                                    <textarea name="note" class="form-control" id="" cols="30"
                                              rows="10">{{ old('note') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" class="dropify form-control" name="image" value="" data-height="120" accept="image/*">
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

    <form action="" id="editProductForm" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="editProductModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Product</h5>
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


    <form action="{{route('admin.product.import')}}" method="post" enctype="multipart/form-data">
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
                                <input type="file" class="dropify form-control" name="import_file" value="{{ old('import_file') }}"
                                       required  data-height="120">
                                <h6 class="text-center mt-2">**Download Format must be Excel**</h6>
                                <h6 class="text-center">
                                    <a href="{{asset('demo-excel/product-list-demo.xlsx')}}" download> Download Demo File</a>
                                </h6>
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
                    {responsivePriority: 4, targets: 4},
                    {responsivePriority: 3, targets: 5, orderable: false},
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
                        $("#editProductForm").attr('action', href);
                        $("#editProductForm .modal-body").html(response.view);
                        $("#editProductModal").modal('show');
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
                }
            });
        }


        $('.slck').on('click', function () {
            $('.deletebtn').show()
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

            let route = "{{ route('admin.productBulk.delete') }}";
            let token = "{{ csrf_token()}}";
            $.ajax({
                url: route,
                type: 'get',
                data: {
                    _token: token,
                    ids: bulk_ids,
                },
                success: function (response) {
                    showSuccessAlert('Success!', 'Products Successfully Deleted ');
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
