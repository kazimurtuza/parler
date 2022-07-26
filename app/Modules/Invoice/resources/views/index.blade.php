@extends('admin.layout.layout')

@section('main_content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-7 d-flex align-items-start align-items-center">
                    @include('admin.partials._datatable_top_section', ['table_id' => 'responsive_datatable2'])
                </div>
                <div class="col-md-5 d-flex justify-content-end">
                    <div><a href="{{route('admin.invoice.create')}}" class="btn btn-export" type="button">Add
                            Invoice</a>
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
                        <th>Invoice No</th>
                        <th class="text-left">Customer</th>
                        <th>Branch</th>
                        <th>Total Discount</th>
                        <th>Total Amount</th>
                        <th>Total Payable</th>

                        <th>
                            <i class="fa fa-cog"></i>
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @if(!empty($invdetails))
                        @foreach($invdetails as $inv)
                            <tr>
                                <td class="table_sl">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="table_text">#INV-{{ $inv->invoice_no }}</td>
                                <td class="table_text">
                                    <div class="table-user">
                                        <div class="tu-image">
                                            <img src="{{ asset($inv->customer->default_photo) }}" alt="{{ $inv->customer->full_name }}">
                                        </div>
                                        <div class="tu-text">
                                            <div class="tu-title">
                                                <p>{{ $inv->customer->full_name }}</p>
                                            </div>
                                            <div class="tu-subtitle">
                                                <p class="font-10">{{ $inv->customer->phone }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="table_text">{{ $inv->branch->name }}</td>

                                <td class="text-center font-weight-600">
                                    {{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }} {{ $inv->discount_amount}}
                                </td>
                                <td class="text-center font-weight-600">
                                    {{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }} {{ $inv->total_amount}}
                                </td>
                                <td class="text-center font-weight-600">
                                    {{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }} {{ $inv->payable_amount}}
                                </td>
                                <td>
                                    <div class="dropdown ms-auto text-center">
                                        <div class="btn-link" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="{{route('admin.invoice.details',$inv->id)}}">Details</a>
                                            <a class="dropdown-item" target="_blank" href="{{route('admin.invoice.pdf',$inv->id)}}">PDF</a>
                                            <a class="dropdown-item" href="{{ route('admin.inv.edit',$inv->id) }}">Edit</a>
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
                    {responsivePriority: 3, targets: 7, orderable: false},
                    {responsivePriority: 4, targets: 6},
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


    </script>

@endsection
