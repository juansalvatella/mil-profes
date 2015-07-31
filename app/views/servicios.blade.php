@extends('layout')

@section('page_meta')

@endsection

@section('page_head')

@endsection

@section('page_css')

@endsection

@section('content')

    <div class="container-fluid top-padding-70 bottom-padding-150 background-lamp">
        <div class="container">

            <div><h1 class="generic-title">@lang('services.title')</h1></div>

            <div><h3 class="generic-subtitle">@lang('services.subtitle')</h3></div>

        </div>
    </div>
    <div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
        <div class="container generic-box top-padding-50 bottom-padding-50 magic-align">
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-10">
                    <div class="row">
                        <div class="col-xs-offset-0 col-xs-12 col-sm-offset-0 col-sm-6 col-md-offset-0 col-md-5 col-lg-offset-1 col-lg-5 services">
                            <h3>@lang('services.title1')</h3>
                            <p>@lang('services.p1-1')</p>
                            <p>@lang('services.p1-2')</p>
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
                            <h3>@lang('services.title2')</h3>
                            <p>@lang('services.p2-1')</p>
                            <p>@lang('services.p2-2')</p>
                        </div>
                    </div>
                    <hr class="hr-servicios-sep"/>
                    <div class="row">
                        <div class="col-xs-offset-0 col-xs-12 col-sm-offset-0 col-sm-6 col-md-offset-0 col-md-5 col-lg-offset-1 col-lg-5 services">
                            <h3>@lang('services.title3')</h3>
                            <p>@lang('services.p3-1')</p>
                            <p>@lang('services.p3-2')</p>
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
                            <h3>@lang('services.title4')</h3>
                            <p>@lang('services.p4-1')</p>
                            <p>
                                <a href="{{ asset('pdf/ejemplo-report.pdf') }}" target="_blank"><strong>Ver ejemplo</strong></a>
                            </p>
                        </div>
                    </div>
                    <hr class="hr-servicios-sep"/>
                    <div class="row top-buffer-25">
                        <div class="col-xs-12 text-center services">
                            <p>@lang('services.call-us')</p>
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

@section('page_js')

@endsection
