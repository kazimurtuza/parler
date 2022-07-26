{{--<link href="{{ asset('assets/backend/vendor/datatables-old/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css">--}}
<link href="{{ asset('assets/backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/backend/vendor/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/backend/vendor/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/backend/vendor/datatables/rowReorder.dataTables.min.css') }}" rel="stylesheet" type="text/css">

@if(isset($with))
    @if($with == 'button')
        <link href="{{ asset('assets/backend/vendor/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css">
    @endif
@endif
