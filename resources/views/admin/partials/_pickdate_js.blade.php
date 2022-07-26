<!-- pickdate -->
<script src="{{ asset('assets/backend/vendor/pickadate/picker.js') }}"></script>
<script src="{{ asset('assets/backend/vendor/pickadate/picker.time.js') }}"></script>
<script src="{{ asset('assets/backend/vendor/pickadate/picker.date.js') }}"></script>

<script>
    (function($) {
        //date picker classic default
        $('.datepicker-default').pickadate({
            format: 'yyyy-mm-dd',
            formatSubmit: 'yyyy-mm-dd',
            hiddenName: true
        });
    })(jQuery);
</script>
