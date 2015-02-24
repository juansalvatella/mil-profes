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
          Utilizamos cookies propias y de terceros para ofrecer nuestros servicios y publicidad basada en tus intereses. Al usar nuestros servicios, aceptas el uso que hacemos de las cookies, según se describe en nuestra <a href="./cookies.html">Política de Privacidad</a>.
        </div>
    @endif

    <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('home') }}">@lang('layout.logo')</a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <div class="pull-left">
                <ul class="nav navbar-nav">
                    <li><a class="left-separator right-separator" href="{{ url('quienes-somos') }}" title="@lang('layout.who')">@lang('layout.who')</a></li>
                    <li><a class="right-separator" href="{{ url('preguntas-frecuentes') }}" title="@lang('layout.faq')">@lang('layout.faq')</a></li>
                    <li><a class="right-separator" href="{{ url('contactanos') }}" title="@lang('layout.contact')">@lang('layout.contact')</a></li>
                </ul>
            </div>
            <div id="loginbox" class="pull-right">
                @if(Auth::check())
                    <a class="right-separator" href="{{ url('userpanel/dashboard') }}" title="Mi Cuenta">Mi Cuenta</a>
                    <a href="{{ url('users/logout') }}" title="Salir">Salir</a>
                @else
                    <a class="right-separator" href="{{ url('users/login') }}" title="@lang('layout.login')">@lang('layout.login')</a>
                    <a href="{{ url('users/create') }}" title="@lang('layout.register')">@lang('layout.register')</a>
                @endif
            </div>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <!-- /HEADER -->

  	@yield('content')

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
                        <div class="row top-buffer-25 text-left" id="footer-follow">@lang('layout.follow_us')&nbsp;&nbsp;&nbsp;&nbsp;<span id="footer-faicons"><a href="#" class="fa fa-facebook-f"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="fa fa-google-plus"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="fa fa-linkedin"></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="fa fa-twitter"></a></span></div>
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
                            <div class="col-xs-3 unpadded"><div class="last-image-container"><a href="{{ url('profiles/school/'.$school->id) }}"><img class="img-thumbnail img-responsive img-recientes" alt="{{ $school->name }}" src="{{ asset('img/logos/'.$school->logo) }}"/></a></div></div>
                        @endforeach
                        </div>
                        <div id="recent-teachers" class="row">
                        @foreach($last_teachers as $teacher)
                                <div class="col-xs-3 unpadded"><div class="last-image-container"><a href="{{ url('profiles/teacher/'.$teacher->id) }}"><img class="img-thumbnail img-responsive img-recientes" alt="{{ $teacher->name }}" src="{{ asset('img/avatars/'.$teacher->avatar) }}"/></a></div></div>
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
                            {{ Form::open(array('action' => 'ContactController@getContactForm')) }}
                            <div class="col-xs-6 text-left">
                                {{ Form::label('contact_name', @trans('layout.contact_form_name'), array('class'=>'contact-form-label')) }}
                                {{ Form::text('contact_name', '', array('class'=>'form-control input-sm','placeholder'=>@trans('layout.name_placeholder'))) }}
                                {{ Form::label('contact_email', @trans('layout.contact_form_email'), array('class'=>'contact-form-label')) }}
                                {{ Form::text('contact_email', '', array('class'=>'form-control input-sm','placeholder'=>@trans('layout.mail_placeholder'))) }}
                                {{ Form::label('contact_subject', @trans('layout.contact_form_subject'), array('class'=>'contact-form-label')) }}
                                {{ Form::text('contact_subject', '', array('class'=>'form-control input-sm','placeholder'=>@trans('layout.subject_placeholder'))) }}
                            </div>
                            <div class="col-xs-6 text-left">
                                {{ Form::label('contact_message', @trans('layout.contact_form_message'), array('class'=>'contact-form-label')) }}
                                {{ Form::textarea('contact_message', '', array('rows' => 4, 'class'=>'form-control input-sm','placeholder'=>@trans('layout.message_placeholder'))) }}
                                {{ Form::submit('Enviar', array('class' => 'btn btn-primary contact-form-submit-btn')) }}
                            </div>
                            {{ Form::close(); }}
                        </div>
                    </div>
                </div>

            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /#footer-apps -->

    <div id="footer">
        <div class="container-fluid">
            <div class="pull-left text-center top-buffer-5">
                <small>@lang('layout.copyright') | @lang('layout.authorship')</small>
            </div>
            <div class="pull-right top-buffer-5">
                <a class="footer-links" href="{{ url('terminos-de-uso') }}" title="@lang('layout.user_terms')">@lang('layout.user_terms')</a> / <a class="footer-links" href="{{ url('politica-de-privacidad') }}" title="@lang('layout.privacy')">@lang('layout.privacy')</a> / <a class="footer-links" href="{{ url('mapa-del-sitio') }}" title="@lang('layout.sitemap')">@lang('layout.sitemap')</a>
            </div>
        </div><!-- /.container -->
    </div><!-- /#footer -->

    <!-- /FOOTER -->

    <!-- Bootstrap related JS -->
    {{ HTML::script('js/bootstrap.min.js') }}
    {{ HTML::script('js/bootstrap-slider.js') }}
    {{ HTML::script('js/bootstrap-formhelpers.min.js') }}

  </body>
</html>