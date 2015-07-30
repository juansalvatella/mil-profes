    {{--TITLE--}}
    <title>
    @if(Request::is('milprofes'))
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
