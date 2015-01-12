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
    {{ HTML::style('css/slider.css') }}
    <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>

    <!-- JQuery JS lib -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
@yield('content')
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
{{ HTML::script('js/bootstrap.min.js') }}
<!-- Bootstrap Slider JavaScript -->
{{ HTML::script('js/bootstrap-slider.js') }}
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<!--<script src="assets/js/ie10-viewport-bug-workaround.js"></script>-->
</body>
</html>