@extends('layout')
@section('content')

    <div class="container-fluid top-padding-70 bottom-padding-150 background-lamp">
        <div class="container">

            <div class="generic-title"><h3>@lang('politica_privacidad.title')</h3></div>

            <div class="generic-subtitle">@lang('politica_privacidad.subtitle')</div>

        </div>
    </div>
    <div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
        <div class="container generic-box top-padding-50 bottom-padding-50 magic-align">

            <div class="col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10 who-padding">

                <div class="col-xs-12 text-justify">@lang('politica_privacidad.p1')</div>

                <div class="col-xs-12 top-buffer-35">
                    <div class="row">
                        <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8 text-center contact-who-logo-container">
                            <span class="who-logo">@lang('politica_privacidad.logo')</span>
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