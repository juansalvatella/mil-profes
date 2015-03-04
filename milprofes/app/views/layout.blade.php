<?php
    //check session status to decide wether to show cookies alert
    if (!Session::has('new-session')) {
        Session::put('new-session', true);
        Session::save();
    } else {
        if(Session::get('new-session')==true) {
            Session::put('new-session', false);
            Session::save();
        }
    }
?>
<?php
    $last_teachers = Milprofes::getLastTeachers(12);
    $last_schools = Milprofes::getLastSchools(12);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/favicon.ico') }}">

    <title>MilProfes</title>

    <!-- CSS -->
    {{ HTML::style('css/bootstrap.min.css') }}
    {{ HTML::style('css/font-awesome.min.css') }}
    {{ HTML::style('css/milprofes.css') }}
    {{ HTML::style('css/slider.css') }}
    {{ HTML::style('css/jquery.raty.css') }}
    {{ HTML::style('css/bootstrap-formhelpers.min.css') }}
    {{ HTML::style('css/map-icons.min.css') }}

    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>

    <!-- JS -->
    {{ HTML::script('js/jquery.min.js') }}
    {{ HTML::script('js/jquery.raty.js') }}
    {{ HTML::script('js/jquery.fittext.js') }}
    {{ HTML::script('js/bootbox.min.js') }}
    {{ HTML::script('js/jquery.lazy.min.js') }}

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- JS Responsive text containers -->
    <script>
        $(document).ready(function($){
            $("#welcome-responsive").fitText(1.9);
            $("#find-responsive").fitText(1.9);
            $(".popular-title-responsive").fitText(3.0);
            $(".names-responsive").fitText();
            $("#recent-responsive").fitText();
            $("#contact-responsive").fitText();
        });
    </script>
</head>

<body>
    <!-- HEADER -->

    @if(Session::has('new-session') && Session::get('new-session')==true)
        <!-- Cookies alert //-->
        <div class="alert alert-dismissible alert-cookies" role="alert">
          <button type="button" class="close" data-dismiss="alert">
              <span aria-hidden="true">&times;</span>
              <span class="sr-only">Close</span>
          </button>
          Utilizamos cookies propias y de terceros para ofrecer nuestros servicios y publicidad basada en tus intereses. Al usar nuestros servicios, aceptas el uso que hacemos de las cookies, según se describe en nuestra <a href="{{ url('politica-de-privacidad') }}">Política de Privacidad</a>.
        </div>
    @endif

    <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
        <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed navbar-collapsed-btn" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}">@lang('layout.logo')</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav text-center">
                <li><a class="left-separator right-separator" href="{{ url('quienes/somos') }}" title="@lang('layout.who')">@lang('layout.who')</a></li>
                <li><a class="right-separator" href="{{ url('preguntas/frecuentes') }}" title="@lang('layout.faq')">@lang('layout.faq')</a></li>
                <li><a class="right-separator" href="{{ url('contactanos') }}" title="@lang('layout.contact')">@lang('layout.contact')</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right text-center">
            @if(Auth::check())
                <li class="text-center"><a class="right-separator" href="{{ url('userpanel/dashboard') }}" title="Mi Cuenta">Mi Cuenta</a></li>
                <li><a href="{{ url('users/logout') }}" title="Salir">Salir</a></li>
            @else
                <li><a data-target="#modal-login" data-toggle="modal" class="right-separator" href="#" title="@lang('layout.login')">@lang('layout.login')</a></li>
                <li><a data-target="#modal-register" data-toggle="modal"  href="#" title="@lang('layout.register')">@lang('layout.register')</a></li>
            @endif
            </ul>
        </div><!--/.nav-collapse -->
        </div>
    </nav>

    <!-- /HEADER -->

  	@yield('content')

    <div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="modal-login" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body login-modal">
                    <div class="row text-center bottom-srs-separator">
                        <span class="login-modal-logo">@lang('layout.logo')</span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 top-buffer-15">
                            <form role="form" method="POST" action="{{{ URL::to('/users/login') }}}" accept-charset="UTF-8" id="login-form">
                                <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                                <fieldset>

                                    @if (Session::get('log-success'))
                                        <div class="alert alert-success">{{{ Session::get('log-success') }}}</div>
                                    @endif
                                    @if (Session::get('log-error'))
                                        <div class="alert alert-error alert-danger">{{{ Session::get('log-error') }}}</div>
                                    @endif
                                    @if (Session::get('log-notice'))
                                        <div class="alert">{{{ Session::get('log-notice') }}}</div>
                                    @endif


                                    <div class="form-group">
                                        <label for="email">@lang('layout.login-username')</label>
                                        <input class="form-control" tabindex="1" placeholder="{{{ @trans('layout.login-username') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}" required="required" data-error="Rellene este campo.">
                                        <small><span class="help-block with-errors"></span></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">
                                            @lang('layout.login-password')
                                        </label>
                                        <input class="form-control" tabindex="2" placeholder="{{{ @trans('layout.login-password') }}}" type="password" name="password" id="password" required="required" data-error="Rellene este campo.">
                                        <small><span class="help-block with-errors"></span></small>
                                        <p class="help-block">
                                            <a href="{{{ URL::to('/users/forgot_password') }}}">@lang('layout.login-forgot-passwd')</a>
                                        </p>
                                    </div>
                                    <div class="checkbox">
                                        <label for="remember">
                                            <input tabindex="4" type="checkbox" name="remember" id="remember" value="1"><small>@lang('layout.login-remind-me')</small>
                                        </label>
                                    </div>

                                    <div class="row text-center top-buffer-15">
                                        <div class="form-group">
                                            <button tabindex="3" type="submit" class="btn btn-login-send">@lang('layout.login-send')</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">@lang('layout.login-cancel')</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $("#login-form").validator();
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-register" tabindex="-1" role="dialog" aria-labelledby="modal-register" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body login-modal">
                    <div class="row text-center bottom-srs-separator">
                        <span class="login-modal-logo">@lang('layout.logo')</span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 top-buffer-15">

                            <form method="POST" action="{{{ URL::to('users') }}}" accept-charset="UTF-8" id="register-form">
                                <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                                <fieldset>

                                @if (Session::get('reg-error'))
                                    @if (is_array(Session::get('reg-error')))
                                        <div class="alert alert-error alert-danger">
                                        {{ head(Session::get('reg-error')) }}
                                        </div>
                                    @else
                                        <div class="alert alert-error alert-danger">
                                            {{ Session::get('reg-error') }}
                                        </div>
                                    @endif
                                @endif
                                @if (Session::get('reg-failure'))
                                    <div class="alert alert-error alert-danger">
                                        {{ Session::get('reg-failure') }}
                                    </div>
                                @endif
                                @if (Session::get('reg-notice'))
                                    <div class="alert">{{ Session::get('reg-notice') }}</div>
                                @endif

                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label for="name">@lang('layout.register-realname')</label>
                                            <input class="form-control" placeholder="{{{@trans('layout.register-realname-ph')}}}" maxlength="50" type="text" name="name" id="name" value="{{{ Input::old('name') }}}" required="required" data-error="Rellene este campo.">
                                            <small><span class="help-block with-errors"></span></small>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label for="lastname">@lang('layout.register-reallastname')</label>
                                            <input class="form-control" placeholder="{{{@trans('layout.register-reallastname-ph')}}}" maxlength="100" type="text" name="lastname" id="lastname" value="{{{ Input::old('lastname') }}}">
                                            <small><span class="help-block with-errors"></span></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label for="address">@lang('layout.register-address')</label>
                                            <input class="form-control" placeholder="{{{@trans('layout.register-address-ph')}}}" maxlength="200" type="text" name="address" id="address" value="{{{ Input::old('address') }}}" required="required" data-error="Rellene este campo.">
                                            <small><span class="help-block with-errors"></span></small>
                                        </div>
                                    </div>
                                </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label for="phone">@lang('layout.register-phone')</label>
                                                <input class="form-control" placeholder="{{{@trans('layout.register-phone-ph')}}}" type="text" pattern="^([0-9]){5,}$" maxlength="20" name="phone" id="phone" value="{{{ Input::old('phone') }}}" data-error="Sólo números, sin espacios.">
                                                <small><span class="help-block with-errors">Sólo números, sin espacios</span></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label for="username">@lang('layout.register-username')</label>
                                                <input class="form-control" placeholder="{{{ @trans('layout.register-username-ph') }}}" pattern="^([_A-z0-9]){5,}$" maxlength="20" type="text" name="username" id="username" value="{{{ Input::old('username') }}}" required="required" data-error="Rellene este campo.">
                                                <small><span class="help-block with-errors">Mínimo 5 con números, letras o guion bajo</span></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label for="email">@lang('layout.register-email') <small>@lang('layout.register-required-confirmation')</small></label>
                                                <input class="form-control" placeholder="{{{ @trans('layout.register-email') }}}" type="email" name="email" id="email" value="{{{ Input::old('email') }}}" required="required" data-error="Introduce una dirección de correo.">
                                                <small><span class="help-block with-errors"></span></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label for="password">@lang('layout.register-password')</label>
                                                <input class="form-control register-password" placeholder="{{{ @trans('layout.register-password') }}}" type="password" pattern=".{6,}" name="password" id="password" required="required" data-error="Rellene este campo.">
                                                <small><span class="help-block with-errors">Mínimo 6 de longitud</span></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label for="password_confirmation">@lang('layout.register-confirm-password')</label>
                                                <input class="form-control" placeholder="{{{ @trans('layout.register-confirm-password-ph') }}}" type="password" data-match=".register-password" name="password_confirmation" id="password_confirmation" required="required" data-error="Rellene este campo." data-match-error="No coincide.">
                                                <small><span class="help-block with-errors"></span></small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row text-center top-buffer-15">
                                        <div class="form-group">
                                            <button tabindex="3" type="submit" class="btn btn-login-send">@lang('layout.register-register')</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">@lang('layout.register-cancel')</button>
                                        </div>
                                    </div>

                                </fieldset>
                            </form>
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $("#register-form").validator();
                                });
                            </script>

                        </div>
                    </div>
                    <div class="row text-left">
                        <div class="col-xs-12 userterms-link">
                            <small><a href="{{url('terminos-de-uso')}}">@lang('layout.register_user-terms')</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <div id="footer-apps">
        <div class="container-fluid">
            <div class="row text-center">

                <div class="col-xs-12 col-sm-offset-0 col-sm-4 bottom-padding">
                    <div class="col-xs-offset-1 col-xs-10">
                        <div class="row text-left"><a id="footer-brand" href="{{ route('home') }}">@lang('layout.contact_logo')</a></div>
                        <div class="row">
                            <div class="col-xs-offset-1 col-xs-10 text-left">
                                <div class="row top-buffer-15 footer-contact"><span class="glyphicon glyphicon-earphone footer-glyphicon"></span>&nbsp;&nbsp;&nbsp;&nbsp; @lang('layout.phone_title') @lang('layout.phone')</div>
                                <div class="row top-buffer-10 footer-contact"><span class="glyphicon glyphicon-envelope footer-glyphicon"></span>&nbsp;&nbsp;&nbsp;&nbsp; @lang('layout.email_title') @lang('layout.email')</div>
                                <div class="row top-buffer-10 footer-contact"><span class="glyphicon glyphicon-home footer-glyphicon"></span>&nbsp;&nbsp;&nbsp;&nbsp; @lang('layout.address_title') @lang('layout.address')</div>
                            </div>
                        </div>
                        <div class="row top-buffer-25 text-left" id="footer-follow">@lang('layout.follow_us')&nbsp;&nbsp;&nbsp;&nbsp;<span id="footer-faicons"><a href="#" class="fa fa-facebook-f"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="fa fa-twitter"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="fa fa-linkedin"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="fa fa-google-plus"></a></span></div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-4 footer-left-separator footer-right-separator bottom-padding">
                    <div id="recent-responsive" class="col-xs-offset-2 col-xs-8 text-center">

                        <div class="row recent-title">@lang('layout.recent_results')</div>

                        <div class="row recent-selectors">
                            <div class="pull-left"><a href="#" class="btn btn-primary lasts-btn-schools">@lang('layout.schools')</a></div>
                            <div class="pull-right"><a href="#" class="btn btn-primary lasts-btn-teachers">@lang('layout.teachers')</a></div>
                        </div>
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#recent-teachers').hide();
                            });
                            $(".lasts-btn-schools").click(function(e){
                                e.preventDefault();
                                $('#recent-teachers').hide();
                                $('#recent-schools').fadeIn(1000);
                            });
                            $(".lasts-btn-teachers").click(function(e){
                                e.preventDefault();
                                $('#recent-schools').hide();
                                $('#recent-teachers').fadeIn(1000);
                            });
                        </script>
                        <div id="recent-schools" class="row">
                        @foreach($last_schools as $school)
                            <div class="col-xs-3 unpadded"><div class="last-image-container"><a href="{{ url('profiles/school/'.$school->id) }}"><img class="img-thumbnail img-responsive img-recientes lazy" alt="{{ $school->name }}" src="" data-src="{{ asset('img/logos/'.$school->logo) }}"/></a></div></div>
                        @endforeach
                        </div>
                        <div id="recent-teachers" class="row">
                        @foreach($last_teachers as $teacher)
                                <div class="col-xs-3 unpadded"><div class="last-image-container"><a href="{{ url('profiles/teacher/'.$teacher->id) }}"><img class="img-thumbnail img-responsive img-recientes lazy" alt="{{ $teacher->name }}" src="" data-src="{{ asset('img/avatars/'.$teacher->avatar) }}"/></a></div></div>
                        @endforeach
                        </div>

                    </div>
                </div>

                <div class="col-xs-12 col-sm-4 bottom-padding">
                    <div class="col-xs-offset-0 col-xs-12 text-center">
                        <div class="row recent-title">
                            <div id="contact-responsive" class="col-xs-offset-2 col-xs-8">
                                @lang('layout.contact_form_title')
                            </div>
                        </div>
                        <div class="row">
                            {{ Form::open(array('action' => 'ContactController@getMiniContactForm','id'=>'mini-contact')) }}
                            <div class="col-xs-6 text-left">
                                {{ Form::label('contact_name', @trans('layout.contact_form_name'), array('class'=>'contact-form-label control-label')) }}
                                <div class="form-group">
                                    {{ Form::text('contact_name', '', array('class'=>'form-control input-sm','placeholder'=>@trans('layout.name_placeholder'),'required','maxlength'=>'50','data-error'=>'Rellene este campo.')) }}
                                    <small><small><span class="help-block with-errors"></span></small></small>
                                </div>
                                {{ Form::label('contact_email', @trans('layout.contact_form_email'), array('class'=>'contact-form-label control-label')) }}
                                <div class="form-group">
                                    {{ Form::email('contact_email', '', array('class'=>'form-control input-sm','placeholder'=>@trans('layout.mail_placeholder'),'required','data-error'=>'Introduce una dirección de correo.')) }}
                                    <small><small><span class="help-block with-errors"></span></small></small>
                                </div>
                                {{ Form::label('contact_subject', @trans('layout.contact_form_subject'), array('class'=>'contact-form-label control-label')) }}
                                <div class="form-group">
                                    {{ Form::text('contact_subject', '', array('class'=>'form-control input-sm','placeholder'=>@trans('layout.subject_placeholder'),'required','maxlength'=>'50','data-error'=>'Rellene este campo.')) }}
                                    <small><small><span class="help-block with-errors"></span></small></small>
                                </div>
                            </div>
                            <div class="col-xs-6 text-left">
                                {{ Form::label('contact_message', @trans('layout.contact_form_message'), array('class'=>'contact-form-label control-label')) }}
                                <div class="form-group">
                                    {{ Form::textarea('contact_message', '', array('rows' => 5, 'class'=>'form-control input-sm','placeholder'=>@trans('layout.message_placeholder'),'required','maxlength'=>'1000','data-error'=>'Rellene este campo.')) }}
                                    <small><small><span class="help-block with-errors"></span></small></small>
                                </div>
                                <div class="form-group">
                                    {{ Form::submit('Enviar', array('class' => 'btn btn-primary contact-form-submit-btn')) }}
                                </div>
                            </div>
                            {{ Form::close(); }}
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $("#mini-contact").validator();
                                });
                            </script>
                        </div>
                    </div>
                            @if (Session::get('minicontact-success'))
                                <div class="col-xs-offset-0 col-xs-12 padded">
                                    <div class="alert alert-success smaller-alert">{{{ Session::get('minicontact-success') }}}</div>
                                </div>
                            @endif
                            @if (Session::get('minicontact-error'))
                                <div class="col-xs-offset-0 col-xs-12 padded">
                                    <div class="alert alert-error alert-danger smaller-alert">{{{ Session::get('minicontact-error') }}}</div>
                                </div>
                            @endif

                </div>

            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /#footer-apps -->

    <div id="footer">
        <div class="container-fluid">
            <div class="pull-left text-center top-buffer-5">
                <small>@lang('layout.copyright') | @lang('layout.authorship')</small>
            </div>
            <div class="pull-right top-buffer-5 footer-links">
                <a href="{{ url('terminos-de-uso') }}" title="@lang('layout.user_terms')">@lang('layout.user_terms')</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{{ url('politica-de-privacidad') }}" title="@lang('layout.privacy')">@lang('layout.privacy')</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{{ url('mapa-del-sitio') }}" title="@lang('layout.sitemap')">@lang('layout.sitemap')</a>
            </div>
        </div><!-- /.container -->
    </div><!-- /#footer -->

    <!-- /FOOTER -->

    <!-- Bootstrap related JS -->
    {{ HTML::script('js/bootstrap.min.js') }}
    {{--{{ HTML::script('js/bootstrap-slider.js') }}--}}
    {{ HTML::script('js/bootstrap-formhelpers.min.js') }}
    {{ HTML::script('js/validator.js') }}

    <script type="text/javascript">
        $(document).ready(function() {
            $("img.lazy").lazy();
        });
    </script>

    @if(Session::get('show_login_modal'))
        <script type="text/javascript">
            $(document).ready(function() {
                $('#modal-login').modal('show');
            });
        </script>
    @endif
    @if(Session::get('show_register_modal'))
        <script type="text/javascript">
            $(document).ready(function() {
                $('#modal-register').modal('show');
            });
        </script>
    @endif

    {{--<script src="http://js.maxmind.com/js/country.js" type="text/javascript"></script>--}}
    {{--<script src="http://js.maxmind.com/js/geoip.js" type="text/javascript" ></script>--}}

</body>
</html>