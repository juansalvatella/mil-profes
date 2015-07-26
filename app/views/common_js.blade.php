{{ HTML::script('js/jquery.min.js') }}
{{ HTML::script('js/jquery.raty.js') }}
{{ HTML::script('js/jquery.fittext.js') }}
{{ HTML::script('js/bootbox.min.js') }}
{{ HTML::script('js/jquery.lazy.min.js') }}
{{ HTML::script('js/consent.js') }}
{{ HTML::script('js/toastr.min.js') }}
{{ HTML::script('js/milprofes.js') }}
{{ HTML::script('js/bootstrap.min.js') }}
{{ HTML::script('js/bootstrap-formhelpers.min.js') }}
{{ HTML::script('js/validator.js') }}
{{ HTML::script('js/analytics.js') }}

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<script type="text/javascript">
$(document).ready(function() {
    $("img.lazy").lazy();

    @if(Session::get('show_login_modal'))
        $('#modal-login').modal('show');
    @endif
    @if(Session::get('show_register_modal'))
        $('#modal-register').modal('show');
    @endif

    $('body').on('click', function (e) {
        $('[data-toggle="popover"]').each(function () {
            //the 'is' for buttons that trigger popups
            //the 'has' for icons within a button that triggers a popup
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });

    $("#login-form").validator();
    $("#register-form").validator();
});
</script>

@if(Session::has('notice'))
    <input type="hidden" name="Ntitle" value="{{ Session::get('Ntitle') }}">
    <input type="hidden" name="Nmsg" value="{{ Session::get('Nmsg') }}">
    <script>
        jQuery(document).ready(function() {
            var sessionTitle = $('input[name=Ntitle]').val();
            var sessionMsg = $('input[name=Nmsg]').val();
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

@if(Session::has('success'))
    <input type="hidden" name="Stitle" value="{{ Session::get('Stitle') }}">
    <input type="hidden" name="Smsg" value="{{ Session::get('Smsg') }}">
    <script>
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
    <script>
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

@if(Session::get('warning'))
    <input type="hidden" name="Wtitle" value="{{ Session::get('Wtitle') }}">
    <input type="hidden" name="Wmsg" value="{{ Session::get('Wmsg') }}">
    <script>
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

@if(Session::has('failure'))
    <input type="hidden" name="Ftitle" value="{{ Session::get('Ftitle') }}">
    <input type="hidden" name="Fmsg" value="{{ Session::get('Fmsg') }}">
    <script>
        jQuery(document).ready(function() {
            var sessionTitle = $('input[name=Ftitle]').val();
            var sessionMsg = $('input[name=Fmsg]').val();
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

@if(Session::get('error'))
    <input type="hidden" name="Etitle" value="{{ Session::get('Etitle') }}">
    <input type="hidden" name="Emsg" value="{{ Session::get('Emsg') }}">
    <script>
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
