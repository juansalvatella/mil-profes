{{--COOKIES ALERT--}}
<div class="alert alert-dismissible alert-cookies" id="cookieBanner" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
    </button>
    Este sitio web utiliza cookies propias y de terceros para mejorar nuestros servicios y mostrarle publicidad relacionada con sus preferencias mediante el análisis de sus hábitos de navegación.
    Si está de acuerdo pulse <a href="#">Acepto</a> o siga navegando. Puede cambiar la configuración u obtener más información haciendo click en <a class="noconsent" href="{{ url('cookies') }}">más información</a>.
</div>

{{--NAVBAR--}}
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
                </div>
            </div>
        </div>
    </div>
</nav>
