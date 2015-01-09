<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../favicon.ico">

    <title>MilProfes</title>

    <!-- Bootstrap core CSS -->
    {{ HTML::style('css/bootstrap.min.css') }}
    <!-- Custom styles for this template -->
    {{ HTML::style('css/milprofes.css') }}
    <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
  	<!-- Cookies alert
    <div class="alert alert-dismissible alert-cookies" role="alert">
      <button type="button" class="close" data-dismiss="alert">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
      </button>
      Utilizamos cookies propias y de terceros para ofrecer nuestros servicios y publicidad basada en tus intereses. Al usar nuestros servicios, aceptas el uso que hacemos de las cookies, según se describe en nuestra <a href="./cookies.html">Política de Cookies</a>.
    </div>
    -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="./index.html"><div class="img-logo"></div></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">@lang('layout.buscador')</a></li>
            <li><a href="#contact" title="@lang('layout.contactanostitle')">@lang('layout.contactanos')</a></li>
            <li><a href="#contact" title="@lang('layout.faqtitle')">@lang('layout.faq')</a></li>
          </ul>
          <div id="loginbox" class="pull-right">
          	<a href="/users/login" title="@lang('layout.logintitle')">@lang('layout.login')</a>
            ·
            <a href="/users/create" title="@lang('layout.registrarmetitle')">@lang('layout.registrarme')</a>
          </div>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
  	@yield('content')
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    {{ HTML::script('js/bootstrap.min.js') }}
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!--<script src="assets/js/ie10-viewport-bug-workaround.js"></script>-->
  </body>
</html>
