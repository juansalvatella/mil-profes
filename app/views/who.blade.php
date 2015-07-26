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
            <div><h1 class="generic-title">@lang('who.title')</h1></div>
            <div><h2 class="generic-subtitle">@lang('who.subtitle')</h2></div>
        </div>
    </div>
    <div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
        <div class="container generic-box top-padding-50 bottom-padding-50 magic-align">
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8 who-padding">
                    <div class="row">
                        <div class="col-xs-12 top-buffer-25">@lang('who.p1')<br><br></div>
                        <div class="col-xs-12">@lang('who.p2')<br><br></div>
                        <div class="col-xs-12">@lang('who.p3')<br><br></div>
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
