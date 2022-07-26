@if(empty($products))
    <tr>
        <td colspan="6" class="text-center">No Product Available</td>
    </tr>
@endif
@if(!empty($products))
    @foreach($products as $product)
        <tr>
            <td class="table_sl">
                {{ $loop->iteration }}
            </td>
            <td class="table_text">{{$product->details->name}}</td>
            <td class="table_text">{{$product->branch->name}}</td>
            <td class="table_number">{{$product->available_qty}}</td>
            <td class="table_number">{{$product->used_qty}}</td>
            {{--<td class="text-center">--}}

            {{--<div class="btn-group mb-1">--}}
            {{--<button class="btn btn-{{ ($product->status == 1)?'success':'danger' }} btn-xs rounded dropdown-toggle status-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">--}}
            {{--@if($product->status == 1)--}}
            {{--Active--}}
            {{--@else--}}
            {{--Inactive--}}
            {{--@endif--}}
            {{--</button>--}}
            {{--<div class="dropdown-menu" style="margin: 0px;">--}}
            {{--<a class="dropdown-item" onclick="updateStatus(this)" href="javascript:void(0)" data-href="{{ route('admin.product.update-status', ['id' => $product->id, 'status' => 1]) }}">Active</a>--}}
            {{--<a class="dropdown-item" onclick="updateStatus(this)" href="javascript:void(0)" data-href="{{ route('admin.product.update-status', ['id' => $product->id, 'status' => 0]) }}">Inactive</a>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</td>--}}
            {{--<td>--}}
                {{--<div class="dropdown ms-auto text-end">--}}
                    {{--<div class="btn-link" data-bs-toggle="dropdown">--}}
                        {{--<i class="fas fa-ellipsis-v"></i>--}}
                    {{--</div>--}}
                    {{--<div class="dropdown-menu dropdown-menu-end">--}}
                        {{--<a class="dropdown-item" href="javascript:void(0)" onclick="editService(this)" data-href="{{ route('admin.product.edit',$product->id) }}">Edit</a>--}}
                        {{--<a class="dropdown-item" href="{{route('product_delete',$product->id)}}">Delete</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</td>--}}
        </tr>
    @endforeach



@endif
