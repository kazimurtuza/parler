@extends('admin.layout.layout')

@section('main_content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-7 d-flex align-items-start align-items-center">
                    @include('admin.partials._datatable_top_section', ['table_id' => 'responsive_datatable2'])
                </div>
                <div class="col-md-5 d-flex justify-content-end">
                </div>
            </div>
            <form action="" method="get">
                <div class="row">
                    @if(isAdmin())
                    <div class="col-md-2 d-flex align-items-start align-items-center">
                        <select name="branch_id" id="branch_id" class="form-control select2" required>
                            <option value="">BRANCH</option>
                            @foreach($branches as $branch)
                                <option value="{{$branch->id}}" {{request()->branch_id ?'selected':''}}>{{$branch->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="col-md-2 d-flex align-items-start align-items-center">
                        <select name="date_range" id="date_range" class="form-control select2" onchange="daterange(this)" required>
                            <option value="">DATE RANGE</option>
                            @foreach(\App\Helpers\CommonHelper::dateRangeItem() as $item)
                                <option value="{{$item}}" {{request()->date_range==$item ? 'selected':''}}>{{$item}}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-md-6" id="daterange" style="display: none">
                        <div class="row m-2">
                            <div class="col-sm-6"><input type="date" name="start_date" value="{{request()->start_date}}" class="form-control start_date"></div>
                            <div class="col-sm-6"><input type="date" name="end_date" value="{{request()->end_date}}" class="form-control end_date"></div>
                        </div>
                    </div>
                    <div class="col-md-2 mt-1">
                        <button type="submit" class="btn btn-success ">Search</button>
                    </div>
                </div>
            </form>

        </div>
        <div class="col-12">
            <div class="rs-table-wrapper">
                <table id="responsive_datatable2" class="w-100">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Total Service</th>
                        <th>Total Amount</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $totalItem=0;
                    $totalAmount=0;
                    ?>

                    @if(!empty($employeesInfo))
                        @foreach($employeesInfo as $key=>$emp)
                            <tr>
                                <td class="table_sl">{{$key+1}}</td>
                                <td class="table_text">{{$emp->employee->user->full_name}}</td>
                                <td class="table_number">{{$item=$emp->total_sale}}</td>
                                <td class="table_number">{{$amount=$emp->total_sale_amount}}</td>
                                <?php
                                $totalItem +=$item;
                                $totalAmount+=$amount;
                                ?>
                            </tr>
                        @endforeach
                    @endif

                    </tbody>
                    <tr class="p-3">
                        <td class="p-3"></td>
                        <td class="p-3 table_number"><strong>Total</strong></td>
                        <td class="p-3 table_number"><strong>{{$totalItem}}</strong></td>
                        <td class="p-3 table_number"><strong>{{$totalAmount}}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

@endsection


@section('css_plugins')
    <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">
    @include('admin.partials._datatable_css', ['with' => 'button'])
@endsection

@section('js_plugins')
    <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
    @include('admin.partials._datatable_js', ['with' => 'button'])
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            daterange(('#date_range'))

            $('.select2').select2()
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
                    {responsivePriority: 3, targets: 2, orderable: false},
                    {responsivePriority: 4, targets: 3},
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

        function daterange(data){
            let item=$(data).val();

            if(item==='Date Range'){
                $('#daterange').show(200);
                $('.end_date').prop('required',true);
                $('.start_date').prop('required',true);
            }else{
                $('#daterange').hide(200);
                $('.end_date').prop('required',false);
                $('.start_date').prop('required',false);
                $('.end_date').val('');
                $('.start_date').val('');
            }
        }




    </script>

@endsection
