    {{--TITLE--}}
    <title>
    @if(Request::is('/'))
        milPROFES. | Profesores particulares y academias
    @elseif(Request::is('milprofes'))
        milPROFES.
    @elseif(Request::is('preguntas-frecuentes'))
        Respuestas a las preguntas frecuentes de milPROFES.
    @elseif(Request::is('contacta'))
        Contacta con el equipo de milPROFES.
    @elseif(Request::is('profe/*') && isset($teacher->username))
        {{{ $teacher->displayName }}} | milPROFES.
    @elseif(Request::is('academia/*') && isset($school->name))
        {{{ $school->name }}} | milPROFES.
    @elseif(Request::is('resultados') && isset($subject) && isset($user_address))
        <?php $subject2 = strtolower($subject); ?>
        Clases particulares de {{{ $subject2 }}} cerca de {{{ $user_address }}}
    @elseif(Request::is('userpanel/*') || Request::is('teacher/*'))
        Mi Panel de Control | milPROFES.
    @else
        milPROFES. | Profesores particulares y academias
    @endif
    </title>

    {{--Favicon--}}
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">

    @if(!Request::is('userpanel/dashboard') && !Request::is('teacher/*') && !Request::is('admin/*'))
        {{--Google Analytics--}}
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
            ga('create', 'UA-61042823-1', 'auto');
            ga('send', 'pageview');
        </script>
    @endif