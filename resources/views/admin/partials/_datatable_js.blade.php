
<script src="{{ asset('assets/backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('assets/backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/backend/vendor/datatables/dataTables.rowReorder.min.js') }}"></script>
<script src="{{ asset('assets/backend/vendor/datatables/dataTables.responsive.min.js') }}"></script>

@if(isset($with))
    @if($with == 'button')
        {{--button start--}}
        <script src="{{ asset('assets/backend/vendor/datatables/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/datatables/buttons.html5.min.js') }}"></script>
        {{--button end--}}
    @endif
@endif
<script>
    function exportData(id) {
        $(id+'_wrapper .buttons-excel').click();
    }
    function tableFilter(input, id) {
        let text = $(input).val();
        $('#'+id).DataTable().search(text).draw();
    }
    function showEntries(input, id) {
        let length = $(input).val();
        $('#'+id).DataTable().page.len(length) // set the length to -1
            .draw();
    }
</script>
