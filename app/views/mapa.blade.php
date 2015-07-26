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
            <div class="generic-title"><h3>@lang('mapa.title')</h3></div>
            <div class="generic-subtitle">@lang('mapa.subtitle')</div>
        </div>
    </div>
    <div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
        <div class="container generic-box top-padding-50 bottom-padding-50 magic-align">
            <div class="row">
                <div class="col-xs-offset-0 col-xs-12 col-sm-offset-0 col-sm-12 who-padding">
                    <div class="col-xs-12 text-justify">@lang('mapa.p1')<br><br></div>
                    <div class="col-xs-12 top-buffer-35">
                        <div class="row">
                            <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8 text-center contact-who-logo-container">
                                <span class="who-logo">@lang('mapa.logo')</span>
                            </div>
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
