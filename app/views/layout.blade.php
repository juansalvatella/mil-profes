<?php
    $last_teachers = Milprofes::getLastTeachers(12);
    $last_schools = Milprofes::getLastSchools(12);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta name="author" content="Milprofes S.L." />
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
@if(Request::is('/') || Request::is('milprofes') || Request::is('preguntas-frecuentes') || Request::is('contacta') || Request::is('profe/*') || Request::is('academia/*'))
    <meta name="robots" content="index,follow"/>
@else
    <meta name="robots" content="noindex,nofollow"/>
@endif
@if(Request::is('/'))
    <meta name="Description" content="Aprende idiomas, ciencias, arte, tecnología, música, baile, cualquier materia... con los profesores particulares y academias de Milprofes. "/>
    <title>Profesores particulares y academias</title>
@elseif(Request::is('milprofes'))
    <meta name="Description" content="Milprofes está formado por un grupo de jóvenes unidos por la pasión y ambición por crear."/>
    <title>MilProfes</title>
@elseif(Request::is('preguntas-frecuentes'))
    <meta name="Description" content="Encuentra respuesta a todas las preguntas que tengas del funcionamiento de la página web de Milprofes en el apartado de preguntas frecuentes. "/>
    <title>Respuestas a las preguntas frecuentes de Milprofes</title>
@elseif(Request::is('contacta'))
    <meta name="Description" content="Contacta con el equipo de Milprofes a través de nuestro formulario. Estaremos encantados de responderte."/>
    <title>Contacta con el equipo de Milprofes</title>
@elseif(Request::is('profe/*') && isset($teacher->description) && isset($teacher->username))
    <meta name="Description" content="{{{ $teacher->description }}}"/>
    <title>{{{ $teacher->username }}} | Milprofes</title>
@elseif(Request::is('academia/*') && isset($school->description) && isset($school->name))
    <meta name="Description" content="{{{ $school->description }}}"/>
    <title>{{{ $school->name }}} | Milprofes</title>
@elseif(Request::is('resultados') && isset($subject) && isset($user_address))
    @if($subject == 'all')
        <?php $subject2 = 'todo'; ?>
    @elseif($subject == 'universitario')
        <?php $subject2 = 'nivel universitario'; ?>
    @elseif($subject == 'musica')
        <?php $subject2 = 'música'; ?>
    @elseif($subject == 'cfp')
        <?php $subject2 = 'CFP'; ?>
    @else
        <?php $subject2 = strtolower($subject); ?>
    @endif
    <title>Clases particulares de {{{ $subject2 }}} cerca de {{{ $user_address }}}</title>
@elseif(Request::is('userpanel/*') || Request::is('teacher/*'))
    <meta name="Description" content="Aprende idiomas, ciencias, arte, tecnología, música, baile, cualquier materia... con los profesores particulares y academias de Milprofes. "/>
    <title>Mi Panel de Control | Milprofes</title>
@else
    <meta name="Description" content="Aprende idiomas, ciencias, arte, tecnología, música, baile, cualquier materia... con los profesores particulares y academias de Milprofes. "/>
    <title>Profesores particulares y academias</title>
@endif

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">

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
    {{ HTML::script('js/consent.js') }}
    {{ HTML::script('js/milprofes.js') }}

    {{--CSS and JS for specific pages--}}
@if(Request::is('userpanel/dashboard'))
    {{ HTML::style('css/jquery.Jcrop.min.css') }}
    {{ HTML::script('js/jquery.Jcrop.min.js') }}
@endif

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- JS Responsive text containers -->
    <script>
        $(document).ready(function($){
            $(".names-responsive").fitText();
            $("#recent-responsive").fitText();
            $("#contact-responsive").fitText();
            $("#footer-brand-responsive").fitText(0.56);
            $(".footer-contact").fitText(1.67);
            $("#footer-follow").fitText(1.72);
            $(".school-rating-span").fitText(1.3);
            $(".teacher-rating-span").fitText(1.3);
            $(".contact-who-logo-container").fitText();
        });
    </script>

    <!-- Google Analytics -->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-61042823-1', 'auto');
        ga('send', 'pageview');
    </script>

</head>

<body>

    <!-- HEADER -->

    <!-- Cookies info //-->
    <div class="alert alert-dismissible alert-cookies" id="cookieBanner" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        Este sitio web utiliza cookies propias y de terceros para mejorar nuestros servicios y mostrarle publicidad relacionada con sus preferencias mediante el análisis de sus hábitos de navegación.
        Si está de acuerdo pulse <a href="#">Acepto</a> o siga navegando. Puede cambiar la configuración u obtener más información haciendo click en <a class="noconsent" href="{{ url('cookies') }}">más información</a>.
        {{--Ejemplos de enlaces relacionados con aceptación de cookies--}}
        {{--<a href="#">Acepto</a>--}}
        {{--<a class="noconsent" href="{{ url('politica-de-privacidad') }}">Política de Privacidad</a>--}}
        {{--<a class="denyConsent noconsent" href="#">No autorizo el uso de cookies</a>--}}
    </div>

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
                    <li><a class="left-separator right-separator" href="{{ url('milprofes') }}" title="@lang('layout.who')">@lang('layout.who')</a></li>
                    <li><a class="right-separator" href="{{ url('preguntas-frecuentes') }}" title="@lang('layout.faq')">@lang('layout.faq')</a></li>
                    <li><a class="right-separator" href="{{ url('contacta') }}" title="@lang('layout.contact')">@lang('layout.contact')</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right text-center">
                @if(Auth::check())
                    <li class="text-center"><a class="right-separator" href="{{ url('userpanel/dashboard') }}" title="Mi Cuenta">Mi Cuenta</a></li>
                    <li><a href="{{ url('users/logout') }}" title="Salir">Salir</a></li>
                @else
                    <li><a data-target="#modal-login" data-toggle="modal" class="right-separator" href="#" title="@lang('layout.login')">@lang('layout.login')</a></li>
                    <li><a id="register-link" data-target="#modal-register" data-toggle="modal"  href="#" title="@lang('layout.register')">@lang('layout.register')</a></li>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
                                        <input class="form-control" tabindex="1" placeholder="{{{ @trans('layout.login-username') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}" required="required" data-error="Rellena este campo.">
                                        <small><span class="help-block with-errors"></span></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">
                                            @lang('layout.login-password')
                                        </label>
                                        <input class="form-control" tabindex="2" placeholder="{{{ @trans('layout.login-password') }}}" type="password" name="password" id="password" required="required" data-error="Rellena este campo.">
                                        <small><span class="help-block with-errors"></span></small>
                                        <p class="help-block">
                                            <a href="{{{ URL::to('/users/forgot-password') }}}">@lang('layout.login-forgot-passwd')</a>
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
                                            <button type="button" class="btn btn-login-send" data-dismiss="modal">@lang('layout.login-cancel')</button>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="name">@lang('layout.register-realname')</label>
                                            <input class="form-control" placeholder="{{{@trans('layout.register-realname-ph')}}}" maxlength="50" type="text" name="name" id="name" value="{{{ Input::old('name') }}}" required="required" data-error="Rellena este campo.">
                                            <small><span class="help-block with-errors"></span></small>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
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
                                            <input class="form-control" placeholder="{{{@trans('layout.register-address-ph')}}}" maxlength="200" type="text" name="address" id="address" value="{{{ Input::old('address') }}}" required="required" data-error="Rellena este campo.">
                                            <small><span class="help-block with-errors"></span></small>
                                        </div>
                                    </div>
                                </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="phone">@lang('layout.register-phone')</label>
                                                <input class="form-control" placeholder="{{{@trans('layout.register-phone-ph')}}}" type="text" pattern="^([0-9]){5,}$" maxlength="20" name="phone" id="phone" value="{{{ Input::old('phone') }}}" data-error="Sólo números, sin espacios.">
                                                <small><span class="help-block with-errors">Sólo números, sin espacios</span></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="username">@lang('layout.register-username')</label>
                                                <input class="form-control" placeholder="{{{ @trans('layout.register-username-ph') }}}" pattern="^([_A-z0-9]){5,}$" maxlength="20" type="text" name="username" id="username" value="{{{ Input::old('username') }}}" required="required" data-error="Al menos 5 caracteres con letras o números.">
                                                <small><span class="help-block with-errors">Mínimo 5 caracters (letras, números, guion bajo)</span></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="email">@lang('layout.register-email') <small>@lang('layout.register-required-confirmation')</small></label>
                                                <input class="form-control" placeholder="{{{ @trans('layout.register-email-ph') }}}" type="email" name="email" id="email2" value="{{{ Input::old('email') }}}" required="required" data-error="Introduce una dirección de correo válida.">
                                                <small><span class="help-block with-errors"></span></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="password">@lang('layout.register-password')</label>
                                                <input class="form-control register-password" placeholder="{{{ @trans('layout.register-password-ph') }}}" type="password" pattern=".{6,}" name="password" id="password2" required="required" data-error="Al menos 6 caracteres de longitud.">
                                                <small><span class="help-block with-errors">Mínimo 6 de longitud</span></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="password_confirmation">@lang('layout.register-confirm-password')</label>
                                                <input class="form-control" placeholder="{{{ @trans('layout.register-confirm-password-ph') }}}" type="password" data-match=".register-password" name="password_confirmation" id="password_confirmation" required="required" data-error="Rellena este campo." data-match-error="No coincide.">
                                                <small><span class="help-block with-errors"></span></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label>
                                                    <input value="1" type="checkbox" name="terms" id="terms" data-error="Debes aceptar las condiciones de uso para registrarte" required="required">
                                                    He leído y acepto las <a target="_blank" href="{{url('condiciones')}}">@lang('layout.register_user-terms')</a>
                                                </label>
                                                <small><span class="help-block with-errors"></span></small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row text-center top-buffer-15">
                                        <div class="form-group">
                                            <button id="register-submit-button" tabindex="3" type="submit" class="btn btn-login-send">@lang('layout.register-register')</button>
                                            <button id="register-cancel-button" type="button" class="btn btn-login-send" data-dismiss="modal">@lang('layout.register-cancel')</button>
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
                    {{--<div class="row text-left">--}}
                        {{--<div class="col-xs-12 userterms-link">--}}
                            {{--<small><a href="{{url('condiciones')}}">@lang('layout.register_user-terms')</a></small>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <div id="footer-apps">
        <div class="container-fluid">
            <div class="row text-center">

                <div class="col-xs-12 col-sm-offset-0 col-sm-4 bottom-padding footer-section-1">
                    <div class="col-xs-offset-1 col-xs-10">
                        <div class="row text-left" id="footer-brand-responsive"><a id="footer-brand" href="{{ route('home') }}">@lang('layout.contact_logo')</a></div>
                        <div class="row">
                            <div class="col-xs-offset-1 col-xs-10 text-left">
                                <div class="row top-buffer-15 footer-contact"><span class="glyphicon glyphicon-earphone footer-glyphicon"></span>&nbsp;&nbsp;&nbsp;&nbsp; @lang('layout.phone_title') @lang('layout.phone')</div>
                                <div class="row top-buffer-10 footer-contact"><span class="glyphicon glyphicon-envelope footer-glyphicon"></span>&nbsp;&nbsp;&nbsp;&nbsp; @lang('layout.email_title') @lang('layout.email')</div>
                                <div class="row top-buffer-10 footer-contact"><span class="glyphicon glyphicon-home footer-glyphicon"></span>&nbsp;&nbsp;&nbsp;&nbsp; @lang('layout.address_title') @lang('layout.address')</div>
                            </div>
                        </div>
                        <div class="row top-buffer-25 text-left" id="footer-follow">@lang('layout.follow_us')&nbsp;&nbsp;&nbsp;&nbsp;<span id="footer-faicons"><a target="_blank" href="{{ Config::get('constants.social-links.facebook') }}" class="fa fa-facebook-f"></a>&nbsp;&nbsp;<a target="_blank" href="{{ Config::get('constants.social-links.twitter') }}" class="fa fa-twitter"></a>&nbsp;&nbsp;<a target="_blank" href="{{ Config::get('constants.social-links.linkedin') }}" class="fa fa-linkedin"></a>&nbsp;&nbsp;<a target="_blank" href="{{ Config::get('constants.social-links.googleplus') }}" rel="publisher" class="fa fa-google-plus"></a>&nbsp;&nbsp;<a target="_blank" href="{{ Config::get('constants.social-links.youtube') }}" class="fa fa-youtube"></a></span></div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-4 footer-left-separator footer-right-separator bottom-padding footer-section-2">
                    <div id="recent-responsive" class="col-xs-offset-2 col-xs-8 text-center">

                        <div class="row recent-title">@lang('layout.recent_results')</div>

                        <div class="row recent-selectors">
                            <div class="unpadded col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left"><a href="#" class="btn lasts-btn-schools">@lang('layout.schools')</a></div>
                            <div class="unpadded col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right"><a href="#" class="btn lasts-btn-teachers">@lang('layout.teachers')</a></div>
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
                            <div class="col-xs-3 unpadded"><div class="last-image-container"><a href="{{ url('academia/'.$school->slug) }}"><img class="img-thumbnail img-responsive img-recientes lazy" alt="{{ $school->name }}" src="{{ asset('img/logos/'.$school->logo) }}" data-src="{{ asset('img/logos/'.$school->logo) }}" /></a></div></div>
                        @endforeach
                        </div>
                        <div id="recent-teachers" class="row">
                        @foreach($last_teachers as $teacher)
                                <div class="col-xs-3 unpadded"><div class="last-image-container"><a href="{{ url('profe/'.$teacher->slug) }}"><img class="img-thumbnail img-responsive img-recientes lazy" alt="{{ $teacher->username }}" src="{{ asset('img/avatars/'.$teacher->avatar) }}" data-src="{{ asset('img/avatars/'.$teacher->avatar) }}" /></a></div></div>
                        @endforeach
                        </div>

                    </div>
                </div>

                <div class="col-xs-12 col-sm-4 bottom-padding footer-section-3">
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
                                    {{ Form::text('contact_name', '', array('class'=>'form-control input-sm','placeholder'=>@trans('layout.name_placeholder'),'required','maxlength'=>'50','data-error'=>'Rellena este campo.')) }}
                                    <small><small><span class="help-block with-errors"></span></small></small>
                                </div>
                                {{ Form::label('contact_email', @trans('layout.contact_form_email'), array('class'=>'contact-form-label control-label')) }}
                                <div class="form-group">
                                    {{ Form::email('contact_email', '', array('class'=>'form-control input-sm','placeholder'=>@trans('layout.mail_placeholder'),'required','data-error'=>'Introduce una dirección de correo.')) }}
                                    <small><small><span class="help-block with-errors"></span></small></small>
                                </div>
                                {{ Form::label('contact_subject', @trans('layout.contact_form_subject'), array('class'=>'contact-form-label control-label')) }}
                                <div class="form-group">
                                    {{ Form::text('contact_subject', '', array('class'=>'form-control input-sm','placeholder'=>@trans('layout.subject_placeholder'),'required','maxlength'=>'50','data-error'=>'Rellena este campo.')) }}
                                    <small><small><span class="help-block with-errors"></span></small></small>
                                </div>
                            </div>
                            <div class="col-xs-6 text-left">
                                {{ Form::label('contact_message', @trans('layout.contact_form_message'), array('class'=>'contact-form-label control-label')) }}
                                <div class="form-group">
                                    {{ Form::textarea('contact_message', '', array('rows' => 5, 'class'=>'form-control input-sm','placeholder'=>@trans('layout.message_placeholder'),'required','maxlength'=>'1000','data-error'=>'Rellena este campo.')) }}
                                    <small><small><span class="help-block with-errors"></span></small></small>
                                </div>
                                <div class="form-group">
                                    {{ Form::submit('Enviar', array('class' => 'btn contact-form-submit-btn')) }}
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
                <small>@lang('layout.copyright')</small> | <div class="netw-link"><a href="http://www.network30.com/" target="_blank"><small>Network3.0</small></a></div><small> & </small><div class="enosis-link"><a href="http://e-nosis.com/" target="_blank"><small>e-nosis</small></a></div>
            </div>
            <div class="pull-right top-buffer-5 footer-links">
                <a href="{{ url('condiciones') }}" title="@lang('layout.user_terms')">@lang('layout.user_terms')</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{{ url('privacidad') }}" title="@lang('layout.privacy')">@lang('layout.privacy')</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{{ url('cookies') }}" title="@lang('layout.cookies')">@lang('layout.cookies')</a>{{--&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{{ url('mapa') }}" title="@lang('layout.sitemap')">@lang('layout.sitemap')</a>--}}
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

    <script type="text/javascript">
        $('body').on('click', function (e) {
            $('[data-toggle="popover"]').each(function () {
                //the 'is' for buttons that trigger popups
                //the 'has' for icons within a button that triggers a popup
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    $(this).popover('hide');
                }
            });
        });
    </script>
    {{--<script src="http://js.maxmind.com/js/country.js" type="text/javascript"></script>--}}
    {{--<script src="http://js.maxmind.com/js/geoip.js" type="text/javascript" ></script>--}}
    {{ HTML::script('js/analytics.js') }}

</body>
</html>