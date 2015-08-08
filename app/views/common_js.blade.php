{{--COMMON LIBRARIES AND PLUGINS--}}
{{-- AND CUSTOM MAIN JS AND SPECIFIC PAGES HANDLERS--}}
{{ Minify::javascript([
    '/js/jquery-1.11.3.js',
    '/js/jquery.raty.js',
    '/js/bootbox.js',
    '/js/toastr.js',
    '/js/bootstrap.js',
    '/js/bootstrap-formhelpers.js',
    '/js/validator.js',
    '/js/milprofes.js'
]) }}

{{--HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries--}}
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

{{--TEST, DEBUG, OTHERS--}}
{{--<script src="http://maps.google.com/maps/api/js?sensor=false"></script>--}}

{{--INITIALIZATORS AND BACKEND DEPENDANT JS--}}
<script type="text/javascript">
$(document).ready(function() {
    @if(Session::has('show_login_modal')) $('#modal-login').modal('show'); @endif
    @if(Session::has('show_register_modal')) $('#modal-register').modal('show'); @endif

    Consent.init(); //cookies consent related JS >>> initializes analytics
    Milprofes.init(); //layout common handlers
});
</script>

@if(Session::has('success'))
    <input type="hidden" name="Stitle" value="{{ Session::get('Stitle') }}">
    <input type="hidden" name="Smsg" value="{{ Session::get('Smsg') }}">
    <script type="text/javascript">
        jQuery(document).ready(function() {
            var sessionTitle = $('input[name=Stitle]').val();
            var sessionMsg = $('input[name=Smsg]').val();
            toastr['success'](sessionMsg,sessionTitle,{
                "closeButton": true,
                "positionClass": "toast-bottom-right",
                "onclick": null,
                "showDuration": "1000",
                "hideEasing": "linear"
            });
        });
    </script>
@endif

@if(Session::has('info'))
    <input type="hidden" name="Ititle" value="{{ Session::get('Ititle') }}">
    <input type="hidden" name="Imsg" value="{{ Session::get('Imsg') }}">
    <script type="text/javascript">
        jQuery(document).ready(function() {
            var sessionTitle = $('input[name=Ititle]').val();
            var sessionMsg = $('input[name=Imsg]').val();
            toastr['info'](sessionMsg,sessionTitle,{
                "closeButton": true,
                "positionClass": "toast-bottom-right",
                "onclick": null,
                "showDuration": "1000",
                "hideEasing": "linear"
            });
        });
    </script>
@endif

@if(Session::has('warning'))
    <input type="hidden" name="Wtitle" value="{{ Session::get('Wtitle') }}">
    <input type="hidden" name="Wmsg" value="{{ Session::get('Wmsg') }}">
    <script type="text/javascript">
        jQuery(document).ready(function() {
            var sessionTitle = $('input[name=Wtitle]').val();
            var sessionMsg = $('input[name=Wmsg]').val();
            toastr['warning'](sessionMsg,sessionTitle,{
                "closeButton": true,
                "positionClass": "toast-bottom-right",
                "onclick": null,
                "showDuration": "1000",
                "hideEasing": "linear"
            });
        });
    </script>
@endif

@if(Session::has('error'))
    <input type="hidden" name="Etitle" value="{{ Session::get('Etitle') }}">
    <input type="hidden" name="Emsg" value="{{ Session::get('Emsg') }}">
    <script type="text/javascript">
        jQuery(document).ready(function() {
            var sessionTitle = $('input[name=Etitle]').val();
            var sessionMsg = $('input[name=Emsg]').val();
            toastr['error'](sessionMsg,sessionTitle,{
                "closeButton": true,
                "positionClass": "toast-bottom-right",
                "onclick": null,
                "showDuration": "1000",
                "hideEasing": "linear"
            });
        });
    </script>
@endif
