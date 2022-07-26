<script src="{{ asset('assets/backend/vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>


<script>
    (function($) {
        "use strict"
        // MAterial Date picker
        $(".mdate").bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false,
            format: 'YYYY-MM-DD'
        });
        /*$('#timepicker').bootstrapMaterialDatePicker({
            format: 'HH:mm',
            time: true,
            date: false
        });
        $('#date-format').bootstrapMaterialDatePicker({
            format: 'dddd DD MMMM YYYY - HH:mm'
        });

        $('#min-date').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY HH:mm',
            minDate: new Date()
        });*/

    })(jQuery);
</script>
