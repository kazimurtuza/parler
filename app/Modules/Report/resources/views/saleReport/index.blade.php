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
                                <option value="{{$branch->id}}" {{ (request()->branch_id == $branch->id)?'selected':'' }}>{{$branch->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="col-md-2 d-flex align-items-start align-items-center">
                        <select name="date_range" id="date_range" class="form-control select2" onchange="daterange(this)" required>
                            <option value="">DATE RANGE</option>
                            @foreach(\App\Helpers\CommonHelper::dateRangeItem() as $item)
                                <option value="{{$item}}" {{ ($item == request()->date_range)?'selected':'' }}>{{$item}}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-md-6" id="daterange" style="display: none">
                        <div class="row m-2">
                            <div class="col-sm-6"><input type="date" name="start_date" class="form-control start_date" value="{{ request()->start_date }}"></div>
                            <div class="col-sm-6"><input type="date" name="end_date" class="form-control end_date" value="{{ request()->end_date }}"></div>
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
                        <th>Invoice No</th>
                        <th>Branch</th>
                        <th>Customer</th>
                        <th>Total Discount</th>
                        <th>Total Amount</th>
                        <th>Total Payable</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $totalDiscount=0;
                    $totalAmount=0;
                    $totalPayable=0;
                    ?>

                    @if(!empty($invdetails))
                        @foreach($invdetails as $inv)
                            <tr>
                                <td class="table_sl">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="table_text">#{{ $inv->invoice_no }}</td>
                                <td class="table_text">{{ $inv->branch->name }}</td>
                                <td class="table_text">{{ $inv->customer->full_name }}</td>
                                {{--<td>{{ $inv->discount_type_text }}</td>--}}
                                {{--<td>{{ class="table_number" $inv->discount_value}}</td>--}}
                                <td class="table_number">{{ $dis=$inv->discount_amount}}</td>
                                <td class="table_number">{{$amount= $inv->total_amount}}</td>
                                <td class="table_number">{{ $payable=$inv->payable_amount}}</td>

                            </tr>
                            <?php
                            $totalDiscount+=$dis;
                            $totalAmount+=$amount;
                            $totalPayable+=$payable;
                            ?>
                        @endforeach
                    @endif

                    </tbody>
                    <tr class="p-3">
                        <td colspan="3"></td>
                        <td class="p-3 table_number"><strong>Total</strong></td>
                        <td class="p-3 table_number"><strong>{{$totalDiscount}}</strong></td>
                        <td class="p-3 table_number"><strong>{{$totalAmount}}</strong></td>
                        <td class="p-3 table_number"><strong>{{$totalPayable}}</strong></td>
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
            daterange($("#date_range"));
            $('.select2').select2();
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
                    {responsivePriority: 3, targets: 3, orderable: false},
                    {responsivePriority: 4, targets: 2},
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
