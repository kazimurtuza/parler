@extends('admin.layout.layout')

@section('main_content')
    <div class="row">

        <form action="{{route('admin.productrequisition.update',$requisition->id)}}" method="post">
            @csrf
            <div class="row">
                <div class="col-4 mt-4">
                    <div class="form-group">
                        <label>Branch<span>:</span></label>
                        <strong>{{$requisition->branch->name}}</strong>

                    </div>

                </div>
                <div class="col-8"></div>

                <div class="col-12">
                    <div class="rs-table-wrapper">

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Product</th>
                                <th scope="col">Unit Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                            </tr>
                            </thead>
                            <tbody id="tbody">
                            @foreach($requisition->details as $key=>$productreq)
                                <tr>
                                    <th scope="row" class="si">{{$key+1}}</th>
                                    <td>
                                        {{$productreq->product->name}}

                                    </td>
                                    <td>{{$productreq->unit_price}}</td>
                                    <td>{{$productreq->quantity}}</td>
                                    <td>{{$productreq->total_amount}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="3"></td>
                                <td class="text-center">Total</td>
                                <td class="totalamount">{{$requisition->details->sum('total_amount')}} TK</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                @if($requisition->approve_status==0)
                    <div class="col-md-6"></div>
                    <div class="col-md-6 d-flex justify-content-end">
                        @if(isAdmin())
                        <a class=" btn btn-sm btn-success" href="{{route('admin.productrequisition.status',['id'=>$requisition->id,'status'=>1])}}">Approve</a> &nbsp;
                        <a class="btn btn-sm btn-danger" href="{{route('admin.productrequisition.status',['id'=>$requisition->id,'status'=>2])}}">Reject</a>
                        @endif
                    </div>
                @endif
                @if($requisition->approve_status==1)
                    <div class="col-md-6"></div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <a class=" btn btn-sm btn-success"  href="javascript:void(0)" onclick="openPurchaseModal({{ $requisition->id }})">Purchase</a>
                    </div>
                @endif


            </div>
        </form>
    </div>
@endsection

@section('page_modals')
    <!-- Modal -->
    <div class="modal fade" id="purchaseConfirmModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{route('admin.inventory.store')}}" method="post">
                    @csrf
                    <input type="hidden" name="requisition_id" id="requisition_id" value="">
                    <div class="modal-header">
                        <h5 class="modal-title">Product Purchase</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="bank">Bank <span class="text-danger">*</span></label>
                            <select name="bank" id="bank" class="form-control select2" required>
                                <option value="">Select Bank</option>
                                @if(!empty($banks))
                                    @foreach($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->name . " (".$bank->account_no." )" }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('css_plugins')
    <link rel="stylesheet" href="{{ asset('assets/backend/vendor/select2/css/select2.min.css') }}">

@endsection

@section('js_plugins')
    <script src="{{ asset('assets/backend/vendor/select2/js/select2.full.min.js') }}"></script>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $(".select2").select2();

        });
        function openPurchaseModal(requisition_id) {
            $("#purchaseConfirmModal #requisition_id").val(requisition_id);
            $("#purchaseConfirmModal").modal('show');
        }
    </script>

@endsection

