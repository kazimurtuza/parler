@extends('admin.layout.layout')

@section('main_content')
    <form action="{{ route('admin.use_product.store') }}" id="addBranchForm" method="post">
        @csrf
        <div class="row">
            <div class="col-sm-6 m-auto p-5 shadow " style="border-radius: 10px">
                <div class="row">
                    <div class="col-md-12">
                        @if(isAdmin())
                        <div class="form-group">
                            <label>Branch<span class="text-danger">*</span></label>
                            <select name="branch_id" id="branch_id" class="form-control" onchange="changeBranch(this.value)" required>
                                <option name="" id="">-SELECT-</option>
                                @foreach($branches as $branch)
                                    <option value="{{$branch->id}}" {{ (old('branch_id') == $branch->id)?'selected':'' }}>{{$branch->name}}</option>
                                @endforeach
                            </select>
                        </div>
                            @endif
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Product<span class="text-danger">*</span></label>
                            <select name="product_id" value="" class="form-control" onchange="getProductQty(this)" required>
                                <option value="">-SELECT-</option>
                                @foreach($product_list as $product)
                                    <option value="{{$product->id}}" id="" >{{$product->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Employee <span class="text-danger">*</span></label>
                            <select name="employee_id" id="employee_id" class="form-control" required>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Quantity <span class="text-danger">*</span><small id="available_qty_show"></small></label>
                            <input type="number" id="qtymaxval" name="qty" class="form-control" min="1" max="" value="1" required>

                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12 d-flex justify-content-center">
                        <button type="submit" class="btn rsbtn-1 color-primary">Save changes</button>
                    </div>
                </div>

            </div>




        </div>
    </form>


@endsection

@section('page_modals')
    <form action="{{ route('admin.use_product.store') }}" id="addBranchForm" method="post">
        @csrf
        <div class="modal fade"  id="addProductModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add User Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label>Branch <span class="text-danger">*</span></label>
                                    <select name="branch_id" id="branch_id" class="form-control" onchange="changeBranch(this.value)" required>
                                        <option name="" id="">-SELECT-</option>
                                       @foreach($branches as $branch)
                                            <option value="{{$branch->id}}" {{ (old('branch_id') == $branch->id)?'selected':'' }}>{{$branch->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Product <span class="text-danger">*</span></label>
                                    <select name="product_id" value="" class="form-control" onchange="getProductQty(this)" required>
                                        <option value="">-SELECT-</option>
                                        @foreach($product_list as $product)
                                            <option value="{{$product->id}}" id="" >{{$product->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Employee <span class="text-danger">*</span></label>
                                    <select name="employee_id" id="employee_id" class="form-control" required>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Quantity <span class="text-danger">*</span><small id="available_qty_show"></small></label>
                                    <input type="number" id="qtymaxval" name="qty" class="form-control" min="1" max="" value="1" required>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-rounded btn-dark" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn rsbtn-1 color-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="" id="editBranchForm" method="post">
        @csrf
        <div class="modal fade" id="editProductModal">
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
                        <button type="submit" class="btn rsbtn-1 color-primary">Save changes</button>
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

            changeBranch({{myBranchId()}})
        });

        function changeBranch(branch_id){

            let urldata="{{route('admin.staff.get')}}";
            $.ajax({
                url: urldata,
                type: "get",
                data: {
                    id:branch_id,
                },
                success: function(response) {
                    let list=response.map(data=>`<option value="${data.id}" data-available"${data.id}">${data.user.full_name}</option>`);
                    let empty='<option value="">-SELECT-<option/>'
                    let listdata=[empty,...list];
                   console.log(listdata);
                   $('#employee_id').html(listdata);
                },
                error: function(xhr) {
                    //Do Something to handle error
                }
            });
        }

        function getProductQty(data){
            let branch_id;
            @if(isAdmin())
                branch_id = $('#branch_id').val();
            @else
                branch_id = {{myBranchId()}};
            @endif

            let product_id=$(data).val();
            let urldata="{{route('admin.product.quantity')}}";
            $.ajax({
                url: urldata,
                type: "get",
                data: {
                    branch_id:branch_id,
                    product_id:product_id,
                },
                success: function(response) {

                    $('#available_qty_show').html(response)
                    $('#qtymaxval').attr('max',response)
                },
                error: function(xhr) {
                    //Do Something to handle error
                }
            });

        }



    </script>

@endsection
