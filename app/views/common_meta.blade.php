<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="author" content="milPROFES S.L." />
<meta name="viewport" content="width=device-width" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
{{--META ROBOTS--}}
<meta name="robots" content="
    @if(Request::is('/') || Request::is('milprofes') || Request::is('preguntas-frecuentes') || Request::is('contacta') || Request::is('profe/*') || Request::is('academia/*'))
        index,follow
    @else
        noindex,nofollow
    @endif
"/>
{{--META DESCRIPTION--}}
<meta name="Description" content="
    @if(Request::is('milprofes'))
        milPROFES. está formado por un grupo de jóvenes unidos por la pasión y ambición por crear.
    @elseif(Request::is('preguntas-frecuentes'))
        Encuentra respuesta a todas las preguntas que tengas del funcionamiento de la página web de milPROFES. en el apartado de preguntas frecuentes.
    @elseif(Request::is('contacta'))
        Contacta con el equipo de milPROFES. a través de nuestro formulario. Estaremos encantados de responderte.
    @elseif(Request::is('profe/*') && isset($teacher->description))
        {{{ $teacher->description }}}
    @elseif(Request::is('academia/*') && isset($school->description))
        {{{ $school->description }}}
    @else
        Aprende idiomas, ciencias, arte, tecnología, música, baile, cualquier materia... con los profesores particulares y academias de milPROFES.
    @endif
"/>