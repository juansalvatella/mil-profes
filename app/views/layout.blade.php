<?php
    $last_teachers = Milprofes::getLastTeachers(12);
    $last_schools = Milprofes::getLastSchools(12);
?>
<!DOCTYPE html>
@if(Request::is('profe/*') || Request::is('academia/*'))
<html lang="es" prefix="og: http://ogp.me/ns#">
@else
<html lang="es">
@endif
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
    <meta name="Description" content="Aprende idiomas, ciencias, arte, tecnología, música, baile, cualquier materia... con los profesores particulares y academias de milPROFES. "/>
    <title>milPROFES. | Profesores particulares y academias</title>
@elseif(Request::is('milprofes'))
    <meta name="Description" content="milPROFES. está formado por un grupo de jóvenes unidos por la pasión y ambición por crear."/>
    <title>milPROFES.</title>
@elseif(Request::is('preguntas-frecuentes'))
    <meta name="Description" content="Encuentra respuesta a todas las preguntas que tengas del funcionamiento de la página web de milPROFES. en el apartado de preguntas frecuentes. "/>
    <title>Respuestas a las preguntas frecuentes de milPROFES.</title>
@elseif(Request::is('contacta'))
    <meta name="Description" content="Contacta con el equipo de milPROFES. a través de nuestro formulario. Estaremos encantados de responderte."/>
    <title>Contacta con el equipo de milPROFES.</title>
@elseif(Request::is('profe/*') && isset($teacher->description) && isset($teacher->username))
    <meta name="Description" content="{{{ $teacher->description }}}"/>
    <title>{{{ $teacher->displayName }}} | milPROFES.</title>
@elseif(Request::is('academia/*') && isset($school->description) && isset($school->name))
    <meta name="Description" content="{{{ $school->description }}}"/>
    <title>{{{ $school->name }}} | milPROFES.</title>
@elseif(Request::is('resultados') && isset($subject) && isset($user_address))
    @if($subject == 'all')
        <?php $subject2 = 'todo'; ?>
    @elseif($subject == 'universitario')
        <?php $subject2 = 'nivel universitario'; ?>
    @elseif($subject == 'musica')
        <?php $subject2 = 'música'; ?>
    @elseif($subject == 'cfp')
        <?php $subject2 = 'formación profesional'; ?>
    @else
        <?php $subject2 = strtolower($subject); ?>
    @endif
    <title>Clases particulares de {{{ $subject2 }}} cerca de {{{ $user_address }}}</title>
@elseif(Request::is('userpanel/*') || Request::is('teacher/*'))
    <meta name="Description" content="Aprende idiomas, ciencias, arte, tecnología, música, baile, cualquier materia... con los profesores particulares y academias de Milprofes."/>
    <title>Mi Panel de Control | milPROFES.</title>
@else
    <meta name="Description" content="Aprende idiomas, ciencias, arte, tecnología, música, baile, cualquier materia... con los profesores particulares y academias de Milprofes."/>
    <title>milPROFES. | Profesores particulares y academias</title>
@endif

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">

    <!-- Common CSS -->
    {{ HTML::style('css/bootstrap.min.css') }}
    {{ HTML::style('css/font-awesome.min.css') }}
    {{ HTML::style('css/milprofes06072015.css') }}
    {{ HTML::style('css/slider.css') }}
    {{ HTML::style('css/jquery.raty.css') }}
    {{ HTML::style('css/bootstrap-formhelpers.min.css') }}
    {{ HTML::style('css/map-icons.min.css') }}
    {{ HTML::style('css/toastr.min.css') }}

    {{--<!-- Fonts -->--}}
    {{--<link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>--}}
    <!-- Common JS -->
    {{ HTML::script('js/jquery.min.js') }}
    {{ HTML::script('js/jquery.raty.js') }}
    {{ HTML::script('js/jquery.fittext.js') }}
    {{ HTML::script('js/bootbox.min.js') }}
    {{ HTML::script('js/jquery.lazy.min.js') }}
    {{ HTML::script('js/consent.js') }}
    {{ HTML::script('js/toastr.min.js') }}
    {{ HTML::script('js/milprofes.js') }}

    {{--Meta & CSS for specific pages--}}
@if(Request::is('/'))
    {{ HTML::style('css/owl.carousel.css') }}
    {{ HTML::style('css/owl.transitions.css') }}
    {{ HTML::style('css/owl.theme.css') }}
@elseif(Request::is('userpanel/dashboard'))
    {{ HTML::style('css/jquery.Jcrop.min.css') }}
@elseif(Request::is('profe/*'))

    <!-- general meta -->
    <meta name="gen-image" content="{{ asset('img/avatars/'.$teacher->avatar) }}" />
    <meta name="gen-title" content="Profe. {{{ $teacher->displayName }}}" />
    <meta name="gen-url" content="{{ Request::url() }}" />
    <meta name="gen-description" content="Visita mi perfil de profe. en milPROFES.com ¿Qué vas a aprender hoy?" />

    <!-- fb meta -->
    <meta property="og:site_name" content="milPROFES." />
    <meta property="og:title" content="Profe. {{{ $teacher->displayName }}}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:image" content="{{ asset('img/avatars/'.$teacher->avatar) }}" />
    <meta property="og:description" content="Visita mi perfil de profe. en milPROFES.com ¿Qué vas a aprender hoy?" />

    <!-- twitter meta -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@milprofes" />
    <meta name="twitter:title" content="Profe. {{{ $teacher->displayName }}}" />
    <meta name="twitter:description" content="Visita mi perfil de profe. en @milprofes ¿Qué vas a aprender hoy?: {{ Request::url() }}" />
    <meta name="twitter:image" content="{{ asset('img/avatars/'.$teacher->avatar) }}" />

    {{ HTML::style('css/rrssb.css') }}

@elseif(Request::is('academia/*'))

    <!-- gen meta -->
    <meta name="gen-image" content="{{ asset('img/logos/'.$school->logo) }}" />
    <meta name="gen-title" content="Academia {{{ $school->name }}}" />
    <meta name="gen-url" content="{{ Request::url() }}" />
    <meta name="gen-description" content="Infórmate de nuestra oferta de cursos en milPROFES.com ¿Qué vas a aprender hoy?" />

    <!-- fb meta -->
    <meta property="og:site_name" content="milPROFES." />
    <meta property="og:title" content="{{{ $school->name }}}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:image" content="{{ asset('img/logos/'.$school->logo) }}" />
    <meta property="og:description" content="Infórmate de nuestra oferta de cursos en milPROFES.com ¿Qué vas a aprender hoy?" />

    <!-- twitter meta -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@milprofes" />
    <meta name="twitter:title" content="{{{ $school->name }}}" />
    <meta name="twitter:description" content="Infórmate de nuestra oferta de cursos en @milprofes ¿Qué vas a aprender hoy?: {{ Request::url() }}" />
    <meta name="twitter:image" content="{{ asset('img/logos/'.$school->logo) }}" />

    {{ HTML::style('css/rrssb.css') }}

@endif

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    {{--<!-- JS Responsive text containers -->--}}
    {{--<script>--}}
        {{--$(document).ready(function($){--}}
            {{--$(".names-responsive").fitText();--}}
            {{--$("#recent-responsive").fitText();--}}
            {{--$("#contact-responsive").fitText();--}}
            {{--$("#footer-brand-responsive").fitText(0.56);--}}
            {{--$(".footer-contact").fitText(1.67);--}}
            {{--$("#footer-follow").fitText(1.72);--}}
            {{--$(".school-rating-span").fitText(1.3);--}}
            {{--$(".teacher-rating-span").fitText(1.3);--}}
            {{--$(".contact-who-logo-container").fitText();--}}
        {{--});--}}
    {{--</script>--}}

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
    </div>
    <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-brand-container hidden-xs hidden-sm">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('img/milprofes-logo-2.png') }}" width="130" height="130" alt="milPROFES"/>
                </a>
            </div>
            <div class="navbar-brand-container hidden-xs hidden-md hidden-lg">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('img/milprofes-logo-2.png') }}" width="100" height="100" alt="milPROFES"/>
                </a>
            </div>
            <div class="navbar-brand-container-mini hidden-sm hidden-md hidden-lg">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('img/milprofes-logo-2.png') }}" width="100" height="100" alt="milPROFES"/>
                </a>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed navbar-collapsed-btn" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div id="navbar" class="collapse navbar-collapse">
                        <ul class="nav navbar-nav text-center">
                            <li class="hidden-md hidden-lg"><span class="distance-correction" style="display:inline-block;height:32px;"></span></li>
                            <li><a href="{{ url('milprofes') }}" title="@lang('layout.who')">@lang('layout.who')</a></li>
                            <li><a href="{{ url('preguntas-frecuentes') }}" title="@lang('layout.faq')">@lang('layout.faq')</a></li>
                            <li><a href="{{ url('contacta') }}" title="@lang('layout.contact')">@lang('layout.contact')</a></li>
                            <li><a href="{{ route('services') }}" title="Servicios">Servicios</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right text-center">
                        @if(Auth::check())
                            <li class="text-center"><a href="{{ url('userpanel/dashboard') }}" title="Mi Cuenta">Mi Cuenta</a></li>
                            <li><a href="{{ url('users/logout') }}" title="Salir">Salir</a></li>
                        @else
                            <li><a data-target="#modal-login" data-toggle="modal" href="javascript:" title="@lang('layout.login')">@lang('layout.login')</a></li>
                            <li>
                                <a id="register-link" data-target="#modal-register" data-toggle="modal"  href="javascript:" title="@lang('layout.register')">
                                    <span><i class="fa fa-pencil"></i> @lang('layout.register_md')</span>
                                    {{--<span class="hidden-xs hidden-sm hidden-lg"><i class="fa fa-pencil"></i> @lang('layout.register_sm')</span>--}}
                                    {{--<span class="hidden-xs hidden-md hidden-lg">@lang('layout.register_xs')</span>--}}
                                </a>
                            </li>
                        @endif
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
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
                                        <div id="dynalert" class="alert alert-warning hidden"></div>

                                    <div class="form-group">
                                        <label for="email">@lang('layout.login-username')</label>
                                        <input class="form-control" tabindex="1" placeholder="{{{ trans('layout.login-username') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}" required="required" data-error="Rellena este campo.">
                                        <small><span class="help-block with-errors"></span></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">
                                            @lang('layout.login-password')
                                        </label>
                                        <input class="form-control" tabindex="2" placeholder="{{{ trans('layout.login-password') }}}" type="password" name="password" id="password" required="required" data-error="Rellena este campo.">
                                        <small><span class="help-block with-errors"></span></small>
                                        <p class="help-block">
                                            <a href="{{{ URL::to('/users/forgot-password') }}}">@lang('layout.login-forgot-passwd')</a>
                                        </p>
                                    </div>
                                    <div class="checkbox">
                                        <label for="remember">
                                            <input tabindex="3" type="checkbox" name="remember" id="remember" value="1"><small>@lang('layout.login-remind-me')</small>
                                        </label>
                                    </div>

                                    <div class="row text-center top-buffer-15">
                                        <div class="form-group">
                                            <button tabindex="4" type="submit" class="btn btn-login-send">@lang('layout.login-send')</button>
                                            <button tabindex="5" type="button" class="btn btn-login-send" data-dismiss="modal">@lang('layout.login-cancel')</button>
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
                                            <input class="form-control" placeholder="{{{trans('layout.register-realname-ph')}}}" maxlength="50" type="text" name="name" id="name" value="{{{ Input::old('name') }}}" required="required" data-error="Rellena este campo.">
                                            <small><span class="help-block with-errors"></span></small>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="lastname">@lang('layout.register-reallastname')</label>
                                            <input class="form-control" placeholder="{{{trans('layout.register-reallastname-ph')}}}" maxlength="100" type="text" name="lastname" id="lastname" value="{{{ Input::old('lastname') }}}">
                                            <small><span class="help-block with-errors"></span></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label for="address">@lang('layout.register-address')</label>
                                            <input class="form-control" placeholder="{{{trans('layout.register-address-ph')}}}" maxlength="200" type="text" name="address" id="address" value="{{{ Input::old('address') }}}" required="required" data-error="Rellena este campo.">
                                            <small><span class="help-block with-errors"></span></small>
                                        </div>
                                    </div>
                                </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="phone">@lang('layout.register-phone')</label>
                                                <input class="form-control" placeholder="{{{trans('layout.register-phone-ph')}}}" type="text" pattern="^([0-9]){5,}$" maxlength="20" name="phone" id="phone" value="{{{ Input::old('phone') }}}" data-error="Sólo números, sin espacios.">
                                                <small><span class="help-block with-errors">Sólo números, sin espacios</span></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="username">@lang('layout.register-username')</label>
                                                <input class="form-control" placeholder="{{{ trans('layout.register-username-ph') }}}" pattern="^([_A-z0-9]){5,}$" maxlength="20" type="text" name="username" id="username" value="{{{ Input::old('username') }}}" required="required" data-error="Al menos 5 caracteres con letras o números.">
                                                <small><span class="help-block with-errors">Mínimo 5 caracters (letras, números, guion bajo)</span></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="email">@lang('layout.register-email') <small>@lang('layout.register-required-confirmation')</small></label>
                                                <input class="form-control" placeholder="{{{ trans('layout.register-email-ph') }}}" type="email" name="email" id="email2" value="{{{ Input::old('email') }}}" required="required" data-error="Introduce una dirección de correo válida.">
                                                <small><span class="help-block with-errors"></span></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="password">@lang('layout.register-password')</label>
                                                <input class="form-control register-password" placeholder="{{{ trans('layout.register-password-ph') }}}" type="password" pattern=".{6,}" name="password" id="password2" required="required" data-error="Al menos 6 caracteres de longitud.">
                                                <small><span class="help-block with-errors">Mínimo 6 de longitud</span></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="password_confirmation">@lang('layout.register-confirm-password')</label>
                                                <input class="form-control" placeholder="{{{ trans('layout.register-confirm-password-ph') }}}" type="password" data-match=".register-password" name="password_confirmation" id="password_confirmation" required="required" data-error="Rellena este campo." data-match-error="No coincide.">
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
    <div id="pre-footer">
        <div class="container-fluid" style="padding-top:15px;padding-bottom:15px;">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-offset-1 col-md-5">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 text-center">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('img/milprofes-logo-3.png') }}" class="hidden-xs hidden-md hidden-lg top-buffer-35" width="100" height="100" alt="milPROFES"/>
                                <img src="{{ asset('img/milprofes-logo-3.png') }}" class="hidden-sm top-buffer-10" width="130" height="130" alt="milPROFES"/>
                            </a>
                        </div>
                        <div class="col-xs-12 col-sm-8 top-padding-25 bottom-padding-25 text-center">
                            <div class="text-left inline-block">
                                <div class="footer-contact"><span class="glyphicon glyphicon-earphone footer-glyphicon"></span>&nbsp;&nbsp;&nbsp;&nbsp; @lang('layout.phone_title') @lang('layout.phone')</div>
                                <div class="top-buffer-10 footer-contact"><span class="glyphicon glyphicon-envelope footer-glyphicon"></span>&nbsp;&nbsp;&nbsp;&nbsp; @lang('layout.email_title') @lang('layout.email')</div>
                                <div class="top-buffer-10 footer-contact"><span class="glyphicon glyphicon-home footer-glyphicon"></span>&nbsp;&nbsp;&nbsp;&nbsp; @lang('layout.address_title') @lang('layout.address')</div>
                                <div class="top-buffer-10 footer-contact" id="footer-faicons">
                                    @lang('layout.follow_us')&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span>
                                        <a target="_blank" href="{{ Config::get('constants.social-links.facebook') }}" class="fa fa-facebook-f"></a>&nbsp;&nbsp;
                                        <a target="_blank" href="{{ Config::get('constants.social-links.twitter') }}" class="fa fa-twitter"></a>&nbsp;&nbsp;
                                        <a target="_blank" href="{{ Config::get('constants.social-links.linkedin') }}" class="fa fa-linkedin"></a>&nbsp;&nbsp;
                                        <a target="_blank" href="{{ Config::get('constants.social-links.googleplus') }}" class="fa fa-google-plus" rel="publisher"></a>&nbsp;&nbsp;
                                        <a target="_blank" href="{{ Config::get('constants.social-links.youtube') }}" class="fa fa-youtube"></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-5">
                    <div class="row">
                        <div class="col-xs-4 footer-sitemap">
                            <h4>Navegar</h4>
                            <ul class="list-unstyled">
                                <li><a href="{{ route('home') }}">Inicio</a></li>
                                <li><a href="{{ route('who') }}">Quiénes somos</a></li>
                                <li><a href="{{ route('faqs')  }}">FAQs</a></li>
                                <li><a href="{{ route('contact') }}">Contáctanos</a></li>
                            </ul>
                        </div>
                        <div class="col-xs-4 footer-sitemap">
                            <h4>Servicios</h4>
                            <ul class="list-unstyled">
                                <li><a href="{{ route('services') }}">Servicios para academias</a></li>
                            </ul>
                        </div>
                        <div class="col-xs-4 footer-sitemap">
                            <h4>Legal</h4>
                            <ul class="list-unstyled">
                                <li><a href="{{ route('terms') }}">Condiciones de uso</a></li>
                                <li><a href="{{ route('privacy') }}">Política de privacidad</a></li>
                                <li><a href="{{ route('cookies') }}">Política de cookies</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-md-offset-1 col-md-10 text-left top-padding-15 bottom-padding-15 small">
                    @lang('layout.copyright')
                    <div class="netw-link">
                        <a href="http://www.network30.com/" target="_blank">Network3.0</a>
                    </div>
                    &
                    <div class="enosis-link">
                        <a href="http://e-nosis.com/" target="_blank">e-nosis</a>
                    </div>
                </div>
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

    @if(Request::is('/'))
        {{ HTML::script('js/owl.carousel.js') }}
        <script type="text/javascript">
            $(document).ready(function() {
                var carousel = $("#schools-carousel");
                carousel.owlCarousel({
                    items: 3,
                    loop: true,
                    autoWidth: false,
                    nav: true,
                    navText: ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
                    dots: false,
                    navSpeed: 500,
                    autoplaySpeed: 500,
                    mouseDrag: false,
                    touchDrag: false,
                    autoplay: true,
                    autoplayTimeout: 3000,
                    autoplayHoverPause: true
                });
//                $('.stars-container2').raty({
//                    readOnly: true,
//                    half: true,
//                    size: 15,
//                    starHalf: '../img/star-half-small2.png',
//                    starOff : '../img/star-off-small2.png',
//                    starOn  : '../img/star-on-small2.png',
//                    score: function(){return $(this).attr('data-score');}
//                });
                $('.stars-container').raty({
                    readOnly: true,
                    half: true,
                    size: 15,
                    starHalf: '../img/star-half-small.png',
                    starOff : '../img/star-off-small.png',
                    starOn  : '../img/star-on-small.png',
                    score: function(){return $(this).attr('data-score');}
                });
//                $(".diamond").mouseenter(function() {
//                    $(this).find('div.diamond-info').css('opacity','1');
//                    $(this).find('a.toggleDisplay').css('display','visible');
//                }).mouseleave(function() {
//                    $(this).find('div.diamond-info').css('opacity','0');
//                    $(this).find('a.toggleDisplay').css('display','none');
//                });
            });
        </script>
    @elseif(Request::is('profe/*'))
        {{ HTML::script('js/rrssb.js') }}
        {{ HTML::script('js/teachers.js') }}
    @elseif(Request::is('academia/*'))
        {{ HTML::script('js/rrssb.js') }}
        {{ HTML::script('js/school.js') }}
    @elseif(Request::is('userpanel/dashboard'))
        {{ HTML::script('js/jquery.Jcrop.min.js') }}
    @elseif(Request::is('admin/schools'))
        {{ HTML::script('js/schools-dashboard.js') }}
    @elseif(Request::is('contacta'))
        {{ HTML::script('js/contact.js') }}
    @endif

    @if(Session::has('notice'))
        <input type="hidden" name="Ntitle" value="{{ Session::get('Ntitle') }}">
        <input type="hidden" name="Nmsg" value="{{ Session::get('Nmsg') }}">
        <script>
            jQuery(document).ready(function() {
                var sessionTitle = $('input[name=Ntitle]').val();
                var sessionMsg = $('input[name=Nmsg]').val();
                toastr['info'](sessionMsg,sessionTitle,{
                    "closeButton": true,
                    "debug": false,
                    "positionClass": "toast-bottom-right",
                    "onclick": null,
                    "showDuration": "1000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
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
                    "debug": false,
                    "positionClass": "toast-bottom-right",
                    "onclick": null,
                    "showDuration": "1000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
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
                    "debug": false,
                    "positionClass": "toast-bottom-right",
                    "onclick": null,
                    "showDuration": "1000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
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
                    "debug": false,
                    "positionClass": "toast-bottom-right",
                    "onclick": null,
                    "showDuration": "1000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
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
                    "debug": false,
                    "positionClass": "toast-bottom-right",
                    "onclick": null,
                    "showDuration": "1000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
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
                    "debug": false,
                    "positionClass": "toast-bottom-right",
                    "onclick": null,
                    "showDuration": "1000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            });
        </script>
    @endif

</body>
</html>
