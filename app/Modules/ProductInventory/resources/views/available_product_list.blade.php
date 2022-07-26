@extends('admin.layout.layout')
@section('main_content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-4 d-flex align-items-start align-items-center">
                    @include('admin.partials._datatable_top_section', ['table_id' => 'responsive_datatable2'])
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    @if(isAdmin())
                    <div class="form-group">
                        <label>Branch <span class="text-danger">*</span></label>
                        <select name="branch" id="branch" class="form-control">
                            <option value="">-SELECT-</option>
                            @foreach($branches as $branch)
                                <option value="{{$branch->id}}">{{$branch->name}}</option>
                            @endforeach
                        </select>
                    </div>
                        @endif
               </div>
                <div class="col-md-2 d-flex justify-content-left">
                    @if(isAdmin())
                    <button onclick="srcProductList()" class="btn btn-success" style="margin-top:27px">Search</button>
                   @endif
               </div>
            </div>

        </div>


        <div class="col-12">
            <div class="rs-table-wrapper">
                <table id="responsive_datatable2" class="w-100">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Product Name</th>
                        <th>branch Name</th>
                        <th>Available Quantity</th>
                        <th>Used Quantity</th>
                        {{--<th>Status</th>--}}
                        {{--<th>--}}
                            {{--<i class="fa fa-cog"></i>--}}
                        {{--</th>--}}
                    </tr>
                    </thead>
                    <tbody id="tbody">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('page_modals')
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
                    { responsivePriority: 3, targets: 3, orderable: false },
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

        function dataTable(){
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
                    { responsivePriority: 3, targets: 3, orderable: false },
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
        }

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

        @if(!isAdmin())
        srcProductList()
        @endif
        function srcProductList(){
           let branch_id= $('#branch').val();
            @if(!isAdmin())
                branch_id={{myBranchId()}}
            @endif
            $.ajax({
                url: "{{route('admin.getAvailableProduct')}}",
                type: "get",
                data: {
                    branch_id:branch_id,
                },
                success: function(response) {
                    $('#tbody').html(response);
                },
                error: function(xhr) {
                    //Do Something to handle error
                }});

        }
    </script>

@endsection
