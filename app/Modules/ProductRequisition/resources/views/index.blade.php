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
                        <a href="{{route('admin.productrequisition.add')}}" class="btn btn-export" type="button" >Add Requisition</a>
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
                        <th>Requisition No</th>
                        <th>Branch Id</th>
                        <th>Requested by</th>
                        <th>Total Amount</th>
                        <th>Approve Status</th>
                        <th>
                            <i class="fa fa-cog"></i>
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @if(!empty($product_requisitions))
                        @foreach($product_requisitions as $pReque)
                            <tr>
                                <td class="table_sl">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="table_text">{{ $pReque->requisition_no }}</td>
                                <td class="table_text">{{ $pReque->branch->name }}</td>
                                <td class="table_text">{{ $pReque->user->first_name}} {{$pReque->user->last_name}}</td>
                                <td class="table_number">{{ $pReque->total_amount}}</td>
                                <td class="table_text">{{ $pReque->approve_status_text}}</td>
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
                                <td>
                                    <div class="dropdown ms-auto text-end">
                                        <div class="btn-link" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item"  href="{{ route('admin.productrequisition.edit',$pReque->id) }}">Edit</a>
                                            {{--<a class="dropdown-item" href="{{route('product_delete',$product->id)}}">Delete</a>--}}
                                            <a class="dropdown-item" href="{{route('admin.productrequisition.details',$pReque->id)}}">Details</a>
                                            @if(isAdmin())
                                            <a class="dropdown-item" href="{{route('admin.productrequisition.status',['id'=>$pReque->id,'status'=>1])}}">Approve</a>
                                            <a class="dropdown-item" href="{{route('admin.productrequisition.status',['id'=>$pReque->id,'status'=>2])}}">Reject</a>
                                            @endif
                                            {{--<a class="dropdown-item" href="{{route('product_delete',$product->id)}}">Delete</a>--}}
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
                    { responsivePriority: 4, targets: 5 },
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

        {{--function updateStatus(button) {--}}
            {{--let href = $(button).attr('data-href');--}}
            {{--let _token = "{{ csrf_token() }}";--}}
            {{--let req_data = {_token: _token};--}}
            {{--$.ajax({--}}
                {{--type: 'POST',--}}
                {{--url: href,--}}
                {{--data: req_data,--}}
                {{--beforeSend: function () {--}}
                    {{--showLoader('Loading...', 'Please Wait');--}}
                {{--},--}}
                {{--success: function (response) {--}}
                    {{--if (response.status == 200) {--}}
                        {{--if (response.updated_status == 1) {--}}
                            {{--$(button).parent().parent().find('.status-btn').html('Active').removeClass('btn-danger').addClass('btn-success');--}}
                        {{--} else {--}}
                            {{--$(button).parent().parent().find('.status-btn').html('Inactive').removeClass('btn-success').addClass('btn-danger');--}}
                        {{--}--}}
                        {{--hideLoader();--}}
                    {{--} else {--}}
                        {{--hideLoader();--}}
                        {{--showErrorAlert('Error!', response.msg);--}}
                    {{--}--}}
                {{--},--}}
                {{--error: function (err) {--}}
                    {{--showHttpErrorAlert(err);--}}
                {{--},--}}
                {{--complete: function () {--}}
                {{--}--}}
            {{--});--}}
        {{--}--}}

        {{--function editService(button) {--}}
            {{--let href = $(button).attr('data-href');--}}
            {{--let _token = "{{ csrf_token() }}";--}}
            {{--let req_data = {_token: _token};--}}
            {{--$.ajax({--}}
                {{--type: 'GET',--}}
                {{--url: href,--}}
                {{--data: req_data,--}}
                {{--beforeSend: function () {--}}
                    {{--showLoader('Loading...', 'Please Wait');--}}
                {{--},--}}
                {{--success: function (response) {--}}
                    {{--if (response.status == 200) {--}}
                        {{--$("#editProductForm").attr('action', href);--}}
                        {{--$("#editProductForm .modal-body").html(response.view);--}}
                        {{--$("#editProductModal").modal('show');--}}
                        {{--hideLoader();--}}
                    {{--} else {--}}
                        {{--hideLoader();--}}
                        {{--showErrorAlert('Error!', response.msg);--}}
                    {{--}--}}
                {{--},--}}
                {{--error: function (err) {--}}
                    {{--showHttpErrorAlert(err);--}}
                {{--},--}}
                {{--complete: function () {--}}
                {{--}--}}
            {{--});--}}
        {{--}--}}
    </script>

@endsection
