@extends('layout')
@section('content')

    <div class="container-fluid top-padding-70 bottom-padding-150 background-lamp">
        <div class="container">
            <div><h1 class="generic-title">@lang('politica_privacidad.title')</h1></div>
            <div><h2 class="generic-subtitle">@lang('politica_privacidad.subtitle')</h2></div>
        </div>
    </div>
    <div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
        <div class="container generic-box top-padding-50 bottom-padding-50 magic-align">
            <div class="row">
                <div class="col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10 who-padding">
                    <p class="full-width text-justify">@lang('politica_privacidad.p1')</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid background-gblack">
        <hr class="hr-page-end"/>
    </div>

@endsection
