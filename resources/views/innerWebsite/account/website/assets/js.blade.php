<!-- REQUIRED SCRIPTS -->
<script 
    src="{{ asset('/js/shortcut.js') }}" type="text/javascript">
</script>

<script 
    src="{{ asset('/js/styleHandler.js') }}" type="text/javascript">
</script>

<script 
    src="{{ asset('/js/validationRules.js') }}" type="text/javascript">
</script>

<script 
    src="{{ asset('/js/customValidate.js') }}" type="text/javascript">
</script>

<script 
    src="{{ asset('/innerWebsite/js/website.js') }}">
</script>


<script 
    src="{{ asset('/plugins/vue-spinner/vue-spinner.js') }}">
</script>


<!-- Date Range Picker -->
<script 
    src="{{ asset('innerWebsite/dist/js/loader.js') }}">
</script>


<!-- Bootstrap 4 -->
<script 
    src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}">
</script>


<script 
src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}">
</script>


<script 
src="{{ asset('/vendor/daterangepicker/moment.min.js') }}">
</script>


<script 
src="{{ asset('/vendor/daterangepicker/daterangepicker.js') }}">
</script>


<script 
src="{{ asset('/vendor/easy-responsive-tabs/easy-responsive-tabs.js') }}">
</script>



<!-- AdminLTE App -->
<script 
    src="{{ asset('innerWebsite/dist/js/adminlte.min.js') }}">
</script>


<!-- Date Range Picker -->
<script 
    src="{{ asset('innerWebsite/dist/js/date_picker.js') }}">
</script>


<!-- Check Balance -->
<script 
    src="{{ asset('innerWebsite/dist/js/checkBalance.js') }}">
</script>

<!-- QRcode Library -->
<script 
    src="{{ asset('innerWebsite/dist/js/qr_packed.js') }}">
</script>

<!-- QRcode Functions -->
<script 
    src="{{ asset('innerWebsite/dist/js/QRcodeFunctions.js') }}">
</script>

<script>
    function change_active_color( dom ) {
        $("#"+dom.id).addClass("change-active-color");
    }
</script>

<script>
   //Date range picker
   $('#date_range_picker').daterangepicker({
        startDate: moment().startOf('day'),
        endDate: moment().add(5, 'days')
   });
</script>

