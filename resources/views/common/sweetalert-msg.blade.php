@if(isset($common_data->alert_type) && ($common_data->alert_type == 'toastr'))
    <script>
        @if (session('error'))
            toastr.error('{{Session::get("error")}}', 'Error!');
        @endif
        @if (session('failed'))
            toastr.error('{{Session::get("failed")}}', 'Error!');
        @endif
        @if (session('success'))
            toastr.success('{{Session::get("success")}}', 'Success');
        @endif
    </script>
@elseif(session('alert_type') && (session('alert_type') == 'toastr'))
    <script>
        @if (session('error'))
        toastr.error('{{Session::get("error")}}', 'Error!');
        @endif
        @if (session('failed'))
        toastr.error('{{Session::get("failed")}}', 'Error!');
        @endif
        @if (session('success'))
        toastr.success('{{Session::get("success")}}', 'Success');
        @endif
    </script>
@else
    @if (session('error'))
        <script type="text/javascript">
            Swal.fire({
                confirmButtonText: 'OKAY',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                title: 'Error',
                html: '{{Session::get("error")}}',
                icon: 'error',
                width: '300px',
                customClass: {
                    confirmButton: 'btn btn-danger swal-okay-button',
                    title: 'swal-title',
                    content: 'swal-subtitle'
                }
            });
            beep();
        </script>
    @endif

    @if (session('failed'))
        <script type="text/javascript">
            Swal.fire({
                confirmButtonText: 'OKAY',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                title: 'Error',
                html: '{{Session::get("failed")}}',
                icon: 'error',
                width: '300px',
                customClass: {
                    confirmButton: 'btn btn-danger swal-okay-button',
                    title: 'swal-title',
                    content: 'swal-subtitle'
                }
            });
            $(document).ready(function () {
                beep();
            });
        </script>
    @endif

    @if (session('success'))
        <script type="text/javascript">
            Swal.fire({
                confirmButtonText: 'OKAY',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                title: 'Success',
                html: '{{Session::get("success")}}',
                icon: 'success',
                width: '300px',
                customClass: {
                    confirmButton: 'btn geo-primary swal-okay-button',
                    title: 'swal-title',
                    content: 'swal-subtitle'
                }
            });
        </script>
    @endif
@endif
