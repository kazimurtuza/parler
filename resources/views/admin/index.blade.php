@extends('admin.layout.layout')
@section('css')
    <style>

    </style>

@endsection

@section('main_content')
    <div class="row index-top-card-wrapper">
        <div class="col-xl-3 col-sm-6 col-6 mpr-5px">
            <div class="card gradient-1 card-bx">
                <div class="card-body d-flex align-items-center">
                    <div class="me-auto text-white">
                        <h2 class="text-white dtext-white">{{ $dashboard_data['total_sale'] }}</h2>
                        <span class="fs-18">Total Sale <small>({{ \Carbon\Carbon::now()->format('F') }})</small></span>
                    </div>
                    <svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M29.0611 39.4402L13.7104 52.5947C12.9941 53.2089 11.9873 53.3497 11.1271 52.9556C10.2697 52.5614 9.7226 51.7041 9.7226 50.7597C9.7226 50.7597 9.7226 26.8794 9.7226 14.5028C9.7226 9.16424 14.0517 4.83655 19.3904 4.83655H38.7289C44.0704 4.83655 48.3995 9.16424 48.3995 14.5028V50.7597C48.3995 51.7041 47.8495 52.5614 46.9922 52.9556C46.1348 53.3497 45.1252 53.2089 44.4088 52.5947L29.0611 39.4402ZM43.5656 14.5028C43.5656 11.8335 41.3996 9.66841 38.7289 9.66841C33.0207 9.66841 25.1014 9.66841 19.3904 9.66841C16.7196 9.66841 14.5565 11.8335 14.5565 14.5028V45.5056L27.4873 34.4215C28.3926 33.646 29.7266 33.646 30.6319 34.4215L43.5656 45.5056V14.5028Z"
                              fill="white"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-6 mpl-5px">
            <div class="card gradient-2 card-bx">
                <div class="card-body d-flex align-items-center">
                    <div class="me-auto text-white">
                        <h2 class="text-white dtext-white">{{ $dashboard_data['total_expense'] }}</h2>
                        <span class="fs-18">Total Expense <small>({{ \Carbon\Carbon::now()->format('F') }})</small></span>
                    </div>
                    <svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M36.25 9.66665V7.24998C36.25 5.91598 37.3327 4.83331 38.6667 4.83331C40.0007 4.83331 41.0833 5.91598 41.0833 7.24998V9.66665C46.4242 9.66665 50.75 13.9949 50.75 19.3333V43.5C50.75 48.8384 46.4242 53.1666 41.0833 53.1666C34.1741 53.1666 23.8283 53.1666 16.9167 53.1666C11.5782 53.1666 7.25 48.8384 7.25 43.5V19.3333C7.25 13.9949 11.5782 9.66665 16.9167 9.66665V7.24998C16.9167 5.91598 17.9993 4.83331 19.3333 4.83331C20.6673 4.83331 21.75 5.91598 21.75 7.24998V9.66665H36.25ZM45.9167 29H12.0833V43.5C12.0833 46.168 14.2487 48.3333 16.9167 48.3333H41.0833C43.7537 48.3333 45.9167 46.168 45.9167 43.5V29ZM33.5748 37.8329L36.9822 34.5172C37.9392 33.5868 39.469 33.6086 40.3994 34.5656C41.3298 35.5202 41.3081 37.0523 40.3535 37.9827L35.3848 42.8161C34.4955 43.6788 33.1011 43.732 32.1513 42.9393L29.4302 40.6677C28.4055 39.8146 28.2677 38.2896 29.1232 37.265C29.9763 36.2403 31.5012 36.1026 32.5259 36.9581L33.5748 37.8329ZM41.0833 14.5V16.9166C41.0833 18.2506 40.0007 19.3333 38.6667 19.3333C37.3327 19.3333 36.25 18.2506 36.25 16.9166V14.5H21.75V16.9166C21.75 18.2506 20.6673 19.3333 19.3333 19.3333C17.9993 19.3333 16.9167 18.2506 16.9167 16.9166V14.5C14.2487 14.5 12.0833 16.6629 12.0833 19.3333V24.1666H45.9167V19.3333C45.9167 16.6629 43.7537 14.5 41.0833 14.5Z"
                              fill="white"/>
                    </svg>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-6 mpr-5px">
            <div class="card gradient-3 card-bx">
                <div class="card-body d-flex align-items-center">
                    <div class="me-auto text-white">
                        <h2 class="text-white dtext-white">{{ $dashboard_data['total_employee'] }}</h2>
                        <span class="fs-18">Total Employees</span>
                    </div>
                    <svg width="58" height="58" viewBox="0 0 58 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M9.66671 38.6667V43.5C9.66671 48.8409 13.995 53.1667 19.3334 53.1667H43.5C48.8409 53.1667 53.1667 48.8409 53.1667 43.5C53.1667 35.455 53.1667 22.5475 53.1667 14.5C53.1667 9.16162 48.8409 4.83337 43.5 4.83337C36.5908 4.83337 26.245 4.83337 19.3334 4.83337C13.995 4.83337 9.66671 9.16162 9.66671 14.5V19.3334C9.66671 20.6674 10.7494 21.75 12.0834 21.75C13.4174 21.75 14.5 20.6674 14.5 19.3334C14.5 19.3334 14.5 17.069 14.5 14.5C14.5 11.832 16.6654 9.66671 19.3334 9.66671H43.5C46.1705 9.66671 48.3334 11.832 48.3334 14.5V43.5C48.3334 46.1705 46.1705 48.3334 43.5 48.3334C36.5908 48.3334 26.245 48.3334 19.3334 48.3334C16.6654 48.3334 14.5 46.1705 14.5 43.5C14.5 40.9335 14.5 38.6667 14.5 38.6667C14.5 37.3351 13.4174 36.25 12.0834 36.25C10.7494 36.25 9.66671 37.3351 9.66671 38.6667ZM27.9995 26.5834L24.8748 23.461C23.9323 22.5161 23.9323 20.9864 24.8748 20.0415C25.8197 19.099 27.3495 19.099 28.292 20.0415L35.542 27.2915C36.4869 28.2364 36.4869 29.7661 35.542 30.711L28.292 37.961C27.3495 38.9035 25.8197 38.9035 24.8748 37.961C23.9323 37.0161 23.9323 35.4864 24.8748 34.5415L27.9995 31.4167H7.25004C5.91604 31.4167 4.83337 30.334 4.83337 29C4.83337 27.6685 5.91604 26.5834 7.25004 26.5834H27.9995Z"
                              fill="white"/>
                    </svg>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-6 mpl-5px">
            <div class="card gradient-4 card-bx">
                <div class="card-body d-flex align-items-center">
                    <div class="me-auto text-white">
                        <h2 class="text-white dtext-white">{{ $dashboard_data['total_customer'] }}</h2>
                        <span class="fs-18">Total Customers</span>
                    </div>
                    <svg width="57" height="46" viewBox="0 0 57 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M8.55512 20.7503L11.4641 17.8435C12.3415 16.9638 12.3415 15.5397 11.4641 14.6601C10.5844 13.7827 9.16031 13.7827 8.28289 14.6601L1.53353 21.4094C0.653858 22.2891 0.653858 23.7132 1.53353 24.5929L8.28289 31.3422C9.16031 32.2197 10.5844 32.2197 11.4641 31.3422C12.3415 30.4626 12.3415 29.0385 11.4641 28.1588L8.55512 25.2498H27.8718C29.1137 25.2498 30.1216 24.2419 30.1216 23C30.1216 21.7604 29.1137 20.7503 27.8718 20.7503H8.55512Z"
                              fill="white"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M16.5038 31.9992V36.4987C16.5038 41.4708 20.5332 45.4979 25.5029 45.4979H48.0008C52.9728 45.4979 57 41.4708 57 36.4987C57 29.0092 57 16.9931 57 9.50129C57 4.53151 52.9728 0.502136 48.0008 0.502136C41.5687 0.502136 31.9373 0.502136 25.5029 0.502136C20.5332 0.502136 16.5038 4.53151 16.5038 9.50129V14.0009C16.5038 15.2427 17.5117 16.2507 18.7536 16.2507C19.9955 16.2507 21.0034 15.2427 21.0034 14.0009C21.0034 14.0009 21.0034 11.8928 21.0034 9.50129C21.0034 7.01752 23.0192 5.00171 25.5029 5.00171H48.0008C50.4868 5.00171 52.5004 7.01752 52.5004 9.50129V36.4987C52.5004 38.9848 50.4868 40.9983 48.0008 40.9983C41.5687 40.9983 31.9373 40.9983 25.5029 40.9983C23.0192 40.9983 21.0034 38.9848 21.0034 36.4987C21.0034 34.1095 21.0034 31.9992 21.0034 31.9992C21.0034 30.7595 19.9955 29.7494 18.7536 29.7494C17.5117 29.7494 16.5038 30.7595 16.5038 31.9992Z"
                              fill="white"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 col-xxl-6 col-lg-6">
            <div class="card border-0 pb-0">
                <div class="card-header border-0 pb-0">
                    <h4 class="card-title">Recent Customer List</h4>
                </div>
                <div class="card-body">
                    <div id="DZ_W_Todo2" class="widget-media dz-scroll height370">
                        <ul class="timeline">
                            @foreach($customers as $custom)
                                <li>
                                    <div class="timeline-panel">
                                        <div class="media me-2 radius">
                                            <img alt="image" class="custom_img" src="{{asset($custom->default_photo)}}">
                                        </div>


                                        <div class="media-body ">
                                            <div class="row">
                                                <div class="col-sm-6"><h5 class="mb-1">{{$custom->full_name}}</h5>
                                                    <small class="d-block">{{$custom->phone}}</small>
                                                </div>
                                                <div class="col-sm-6"><span
                                                            class="tag">{{$custom->membership->title}} Member</span>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="dropdown">
                                            <a type="button" class="btn btn-primary light sharp"
                                               href="{{route('admin.customer.index')}}">Go</a>

                                        </div>
                                    </div>
                                </li>

                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-xxl-6">
            <div class="row">

                <div class="col-xl-12 col-sm-6">
                    <div class="card">
                        <div class="card-header border-0 pb-0">
                            <h4 class="mb-0">Today's Branch Sale</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    @foreach($branches as $key=>$branch)
                                        <?php
                                        $branch_sale = $branch->sale->where('created_at', '>=', \Carbon\Carbon::now()->startOfDay())
                                            ->sum('payable_amount');
                                        $percen = (100 * $branch_sale) / (($today_total_sale == 0)?1:$today_total_sale);?>
                                        <h6 class="mt-3"><span class="txtCapitalize">{{$branch->name}}</span>
                                            <span class="pull-end float-end tagprc gradient-{{$key+1}}">{{ intval($percen)}}%</span>
                                        </h6>
                                        <div class="progress ">
                                            <div class="progress-bar  progress-animated gradient-{{$key+1}}"
                                                 style="width:{{$percen}}%; height:6px;"
                                                 role="progressbar">
                                                <span class="sr-only">{{ intval($percen)}}%</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>


                            <div class="d-flex mt-4 progress-bar-legend align-items-center justify-content-between">

                                <div class="row p-3">
                                    @foreach($branches as $key=>$branch)
                                        <div class="col-3 mt-3 bxsdw">
                                            <div class="d-flex">
                                                <span class="marker gradient-{{$key+1}}"></span>
                                                <div>
                                                    <p class="status txtCapitalize">{{$branch->name}}</p>
                                                    <span class="result">{{\App\Helpers\CommonHelper::getCurrency()['symbol']}} {{$branch->sale->where('created_at','>=',\Carbon\Carbon::now()->startOfDay())->sum('payable_amount')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-xl-3 col-xxl-4">
            <div class="row">

                <div class="col-xl-12 col-sm-6">
                    <div class="card text-white  text-black">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <strong class="mb-0 hdtx">Bank Balance</strong></li>
                            @foreach($banks as $bank)
                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0"> <strong
                                                class="txtCapitalize">{{$bank->name}}</strong> :</span><strong
                                            class="tg"><span>{{\App\Helpers\CommonHelper::getCurrency()['symbol']}}</span> {{$bank->bankBalance->where('type','in')->sum('amount')-$bank->bankBalance->where('type','out')->sum('amount')}}
                                    </strong>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Recent Invoice</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-responsive-sm">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Invoice No</th>
                                <th>Customer</th>
                                <th>Branch</th>
                                <th>Total Payable</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $key=>$inv)
                            <tr>
                                <th>{{$key+1}}</th>
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
                                    {{ \App\Helpers\CommonHelper::getCurrency()['symbol'] }} {{ $inv->payable_amount}}
                                </td>
                            </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



    </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Pending Requisition</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive-md">
                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Requisition No</th>
                                    <th>Branch</th>
                                    <th>Requested by</th>
                                    <th>Total Amount</th>
                                    <th>Approve Status</th>
                                    <th class="text-center">
                                        <i class="fa fa-cog"></i>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>


                                @foreach($product_requisitions as $pReque)
                                    <tr>
                                        <td class="table_sl">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="table_text">#{{ $pReque->requisition_no }}</td>
                                        <td class="table_text">{{ $pReque->branch->name }}</td>
                                        <td class="table_text">{{ $pReque->user->first_name}} {{$pReque->user->last_name}}</td>
                                        <td class="table_number">{{ $pReque->total_amount}}</td>
                                        <td class="text-center"><span class="badge light badge-danger text-center">{{ $pReque->approve_status_text}}</span></td>
                                        <td>
                                            <div class="dropdown ms-auto text-center">
                                                <div class="btn-link btn gradient-3 light sharp text-center" data-bs-toggle="dropdown">
                                                    <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                                </div>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="{{route('admin.productrequisition.details',$pReque->id)}}">Details</a>

                                                        <a class="dropdown-item"  href="{{ route('admin.productrequisition.edit',$pReque->id) }}">Edit</a>
                                                        @if(isAdmin())
                                                            <a class="dropdown-item" href="{{route('admin.productrequisition.status',['id'=>$pReque->id,'status'=>1])}}">Approve</a>
                                                        @endif
                                                        <a class="dropdown-item" href="{{route('admin.productrequisition.status',['id'=>$pReque->id,'status'=>2])}}">Reject</a>



                                                    {{--<a class="dropdown-item" href="{{route('product_delete',$product->id)}}">Delete</a>--}}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Recent Expenses</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive-md">
                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Branch</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th>Employee</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>


                                @foreach($expenses as $expense)
                                    <tr>
                                        <td class="table_sl">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="table_text">{{ $expense->branch->name }}</td>
                                        <td class="table_text">{{ $expense->category->name }}</td>
                                        <td class="table_text">{{ $expense->subcategory->name }}</td>
                                        <td class="table_text">{{ $expense->employee->user->full_name }}</td>
                                        <td class="table_number">{{ $expense->amount }}</td>

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection

@section('css_plugins')
    <link rel="stylesheet" href="{{ asset('assets/backend/vendor/chartist/css/chartist.min.css') }}">
    <link href="{{ asset('assets/backend/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"
          rel="stylesheet">
@endsection

@section('js_plugins')
    <!-- Required vendors -->
    <script src="{{ asset('assets/backend/vendor/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Chart piety plugin files -->
    <script src="{{ asset('assets/backend/vendor/peity/jquery.peity.min.js') }}"></script>
    <!-- Apex Chart -->
    <script src="{{ asset('assets/backend/vendor/apexchart/apexchart.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/bootstrap-datetimepicker/js/moment.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <!-- Dashboard 1 -->
    <script src="{{ asset('assets/backend/js/dashboard/dashboard-1.js') }}"></script>
@endsection

@section('js')
    <script>
        $(function () {
            $('#datetimepicker').datetimepicker({
                inline: true,
            });
        });

        $(document).ready(function () {
            $(".booking-calender .fa.fa-clock-o").removeClass(this);
            $(".booking-calender .fa.fa-clock-o").addClass('fa-clock');
        });

        // sale label

        // sale label
    </script>
@endsection
