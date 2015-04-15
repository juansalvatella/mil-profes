@extends('layout')
@section('content')

    <div class="container-fluid top-padding-70 bottom-padding-150 background-lamp">
        <div class="container">

            <div class="generic-title"><h3>@lang('who.title')</h3></div>

            <div class="generic-subtitle">@lang('who.subtitle')</div>

        </div>
    </div>
    <div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
        <div class="container generic-box top-padding-50 bottom-padding-50 magic-align">

            <div class="col-xs-offset-0 col-xs-12 col-sm-offset-0 col-sm-12 who-padding">

                <div class="col-xs-12 text-justify">@lang('who.p1')<br><br></div>

                <div class="col-xs-12 text-justify">@lang('who.p2')<br><br></div>

                <div class="col-xs-12 text-justify">@lang('who.p3')<br><br></div>

                <div class="col-xs-12 top-buffer-35">
                    <div class="row">
                        <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8 text-center contact-who-logo-container">
                            <span class="who-logo">@lang('who.logo')</span>
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