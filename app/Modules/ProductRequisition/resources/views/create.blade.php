@extends('admin.layout.layout')

@section('main_content')
    <div class="row">
        <div class="col-12">
            <form action="{{route('admin.productrequisition.stor')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-4">
                        @if(isAdmin())
                        <div class="form-group">
                            <label>Branch<span class="text-danger">*</span></label>
                            <select name="branch_id" class="form-control default-select" required>
                                <option value="">-SELECT-</option>
                                @foreach($branches as $branch)
                                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                                @endforeach
                            </select>
                        </div>
                            @endif

                    </div>
                    <div class="col-8"></div>

                    <div class="col-12">
                        <div class="rs-table-wrapper">

                            <table class="table table-bordered form_table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Unit Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                    <th scope="col"><i class="fa fa-cog"></i></th>
                                </tr>
                                </thead>
                                <tbody id="tbody">
                                <tr>
                                    <th scope="row" class="si">1</th>
                                    <td>
                                        <select name="product_id[]" class="form-control product product_select2" onchange="changeProduct(this)">
                                            <option value="">-SELECT-</option>
                                            @foreach($products as $product)
                                                <option value="{{$product->id}}"
                                                        data-unitprice="{{$product->price}}">{{$product->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" min="1" value="0" step="any" name="price[]" class="form-control price" oninput="changePrice(this)">
                                    </td>
                                    <td>
                                        <input type="number" min="0" value="1" step="any" name="quantity[]" class="form-control quantity" oninput="changeQty(this)">
                                    </td>
                                    <td>
                                        <span class="total">0</span>
                                    </td>
                                    <td></td>
                                </tr>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-center">Total</td>
                                    <td class="totalamount"></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <button class="btn rsbtn-1 color-primary" id="addproduct" type="button">+ Add</button>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <button class="btn w-25 rsbtn-1 bg-success" type="submit">Submit</button>
                    </div>


                </div>
            </form>
        </div>

    </div>

    <div style="display: none;">
        <div id="hidden-data">
            <div id="new_product_row">
                <table>
                    <tbody>
                        <tr>
                            <th scope="row" class="si">1</th>
                            <td>
                                <select name="product_id[]" class="form-control product product_select2" onchange="changeProduct(this)" required>
                                    <option value="">-SELECT-</option>
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}" data-unitprice="{{$product->price}}">{{$product->name}}</option>
                                    @endforeach

                                </select>
                            </td>
                            <td><input type="number" min="1" value="0"  step="any" name="price[]" class="form-control price" oninput="changePrice(this)"></td>
                            <td><input type="number" min="0" value="1"  step="any" name="quantity[]" class="form-control quantity" oninput="changeQty(this)"></td>
                            <td><span class="total">0</span></td>
                            <td>
                                <button type="button" class="btn btn-xs btn-danger" onclick="removeProductRow(this)">
                                    <i class="fa fa-times"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
@section('page_modals')
    <form action="{{ route('admin.product.store') }}" id="addProductForm" onsubmit="addproduct()" method="post" enctype="multipart/form-data">
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
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" accept="image/*" class="form-control" id="image" name="image" value="{{ old('image') }}" >
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Price <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Note <span class="text-danger">*</span></label>
                                    <textarea name="note" class="form-control" id="note" cols="30" rows="10">{{ old('note') }}</textarea>
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
@endsection


@section('css_plugins')
    <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
@endsection

@section('js_plugins')
    <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
@endsection

@section('js')
    <script>
        function select2Refresh() {
            $(".form_table .product_select2").select2({
                allowClear: false,
                placeholder: "Search Product",
                language: {
                    noResults: function () {
                        return $('<a  type="button" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product</a>')

                    }
                },
                dropdownCssClass: "dropdown_z_index_9"
            });
        }
        var product_list = [];
        var single_product;
        $(document).ready(function () {
            select2Refresh();

            $('#addproduct').on('click', function () {
                let html = $("#new_product_row table tbody").html();
                $('#tbody').append(html);
                countsinumber();
                select2Refresh();
                // $(".product_select2").select2({
                //     allowClear: true,
                //     placeholder: "Search Product",
                //     language: {
                //         noResults: function () {
                //             return $('<a  type="button" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product</a>')
                //
                //         }
                //     }
                // });
            });





        });

        function removeProductRow(button) {
            $(button).parent().parent().remove();
            countsinumber();
            totalamount();
        }
        function changeProduct(product) {
            let unnitprice = $('option:selected', product).attr('data-unitprice');
            // let unnitprice = $(product).select2().find(":selected").data("unitprice");
            // console.log(unnitprice);
            let qty = $(product).parent().parent().find('.quantity').val(1);
            $(product).parent().parent().find('.price').val(unnitprice);
            $(product).parent().parent().find('.total').html(unnitprice);
            totalamount();
        }

        function changePrice(input) {
            let unnitprice = $(input).val();
            let qut = $(input).parent().parent().find('.quantity').val();
            let total = (qut * unnitprice).toFixed(2)
            $(input).parent().parent().find('.total').html(total);
            totalamount()
        }

        function changeQty(input) {
            let qty = $(input).val();
            let unnitprice = $(input).parent().parent().find('.price').val();
            let total = (qty * unnitprice).toFixed(2)
            $(input).parent().parent().find('.total').html(total);
            totalamount()
        }

        function countsinumber() {
            let i = 1;
            $('.si').each(function (index, data) {

                $(data).html(i);
                i = i + 1;
            })
        }

        function totalamount() {
            let total = 0;
            $('.total').each(function (index, data) {
                $price = +$(data).html();
                total += $price
            });
            $('.totalamount').html(total);
        }

        function addproduct(){
            event.preventDefault()
            let name=$('#name').val()
            let image=$('#image').val()
            let price=$('#price').val()
            let note=$('#note').val()

            let route = "{{ route('admin.addpriduct.productdata') }}";
            let token = "{{ csrf_token()}}";
            $.ajax({
                url: route,
                type: 'POST',
                data: {
                    _token:token,
                    name:name,
                    image:image,
                    price:price,
                    note:note,

                },
                success: function(response) {
                  $optionlist=  response.map(datalist => `<option valiue="${datalist.id}" data-unitprice="${datalist.price}">${datalist.name}</option>`);
                  $('.product').html($optionlist);
                  $('#addProductModal').modal('hide');

                },
                error: function(xhr) {
                    //Do Something to handle error
                }});


        }
    </script>

@endsection
