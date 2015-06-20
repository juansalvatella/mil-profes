@extends('layout')
@section('content')

    <div class="container-fluid top-padding-70 bottom-padding-150 background-lamp">
        <div class="container">

            <div><h1 class="generic-title">@lang('services.title')</h1></div>

            <div><h2 class="generic-subtitle">@lang('services.subtitle')</h3></div>

        </div>
    </div>
    <div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
        <div class="container generic-box top-padding-50 bottom-padding-50 magic-align">
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-10">
                    <div class="row">
                        <div class="col-xs-offset-0 col-xs-12 col-sm-offset-0 col-sm-6 col-md-offset-0 col-md-5 col-lg-offset-1 col-lg-5 services">
                            <h3>Búsquedas geolocalizadas:</h3>
                            <p>
                                Una de las principales causas de abandono en las academias por parte de los estudiantes
                                es la distancia hasta al centro. Nuestra página tiene una solución a este problema:
                            </p>
                            <p>
                                Ofrecemos resultados ordenados por proximidad, aumentando así la probabilidad de que los
                                estudiantes de su municipio se pongan en contacto con su centro de estudios y reduciendo
                                la posibilidad de abandono y fracaso educativo.
                            </p>
                        </div>
                        <div class="col-xs-12 col-sm-6 text-center services">
                            <div class="hidden-xs hidden-sm" style="height:20px;">&nbsp;</div>
                            <div class="hidden-xs hidden-md hidden-lg" style="height:40px;">&nbsp;</div>
                            <img style="display: inline-block" src="{{ asset('img/news/geoloctrans.png') }}" alt="Búsquedas geolocalizadas">
                        </div>
                    </div>
                    <hr class="hr-servicios-sep"/>
                    <div class="row">
                        <div class="hidden-xs col-xs-12 col-sm-6 text-center services">
                            <div class="hidden-xs hidden-sm" style="height:10px;">&nbsp;</div>
                            <div class="hidden-xs hidden-md hidden-lg" style="height:40px;">&nbsp;</div>
                            <img style="display: inline-block" src="http://milprofes.com/img/news/profiles300.png" alt="Cero anuncios. Todo perfiles">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5 services">
                            <h3>Cero anuncios. Todo perfiles:</h3>
                            <p>
                                El equipo de milProfes crea el perfil de su centro educativo con toda la información que
                                el estudiante necesita (horarios, cursos, localizaci&oacute;n...).
                            </p>
                            <p>
                                Adem&aacute;as, nuestro equipo gestiona y actualiza su perfil regularmente para que los
                                empleados de su academia no tengan que dedicar tiempo a estas tareas.
                            </p>
                        </div>
                    </div>
                    <hr class="hr-servicios-sep"/>
                    <div class="row">
                        <div class="col-xs-offset-0 col-xs-12 col-sm-offset-0 col-sm-6 col-md-offset-0 col-md-5 col-lg-offset-1 col-lg-5 services">
                            <h3>Posicionamiento en buscadores, SEO y redes sociales:</h3>
                            <p>
                                Su perfil no sólo es accesible desde nuestra web, sino que trabajamos constantemente para
                                situarle en los primeros puestos de los principales motores de búsqueda y difundir su oferta de
                                cursos en las redes sociales.
                            </p>
                            <p>
                                Nuestro equipo gestiona diferentes canales de publicidad, desde Facebook hasta carteles
                                publicitarios. Nos encargamos del SEO en nuestra web para que no tengan que ocuparse de ese
                                trabajo y puedan dedicar sus esfuerzos a ser los mejores en su área.
                            </p>
                        </div>
                        <div class="hidden-xs col-xs-12 col-sm-6 text-center services">
                            <div class="hidden-xs hidden-sm" style="height:20px;">&nbsp;</div>
                            <div class="hidden-xs hidden-md hidden-lg" style="height:40px;">&nbsp;</div>
                            <img style="display: inline-block" src="http://milprofes.com/img/news/seo300.png" alt="Posicionamiento en buscadores, SEO y redes sociales">
                        </div>
                    </div>
                    <hr class="hr-servicios-sep"/>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 text-center services">
                            <div class="hidden-xs hidden-sm" style="height:20px;">&nbsp;</div>
                            <div class="hidden-xs hidden-md hidden-lg" style="height:40px;">&nbsp;</div>
                            <img style="display: inline-block" src="http://milprofes.com/img/news/informes.png" alt="Informes mensuales">
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5 services">
                            <h3>Informes mensuales:</h3>
                            <p>
                                Le informamos periódicamente de las estadísticas que pueden serle de interés: número de
                                personas que se han interesado en contactarle, búsquedas relacionadas de usuarios cercanos,
                                demanda de sus cursos publicados... Además adjuntamos las valoraciones y comentarios de los
                                alumnos de su academia.
                            </p>
                            <p>
                                <a href="{{ asset('pdf/ejemplo-report.pdf') }}" target="_blank"><strong>Ver ejemplo</strong></a>
                            </p>
                        </div>
                    </div>
                    <hr class="hr-servicios-sep"/>
                    <div class="row top-buffer-25">
                        <div class="col-xs-12 text-center services">
                            <p>
                                Para formar parte de nuestra web, puede llamarnos al <strong>696089184</strong> o contactar con nosotros
                            </p>
                        </div>
                        <div class="col-xs-12 text-center">
                            <a href="{{ route('contact') }}" class="btn input-lg faqs-btn">@lang('services.contact-us')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid background-gblack">
        <hr class="hr-page-end"/>
    </div>

@endsection