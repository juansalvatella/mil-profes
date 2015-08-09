@extends('layout')

@section('page_meta')

@endsection

@section('page_head')

@endsection

@section('page_css')

@endsection

@section('content')
<div class="container-fluid" id="error-container">
    <div class="row" id="err-code-container">
        <div class="col-xs-offset-0 hidden-xs col-sm-offset-0 col-sm-2 col-md-offset-0 col-md-3 col-lg-offset-1 col-lg-3 err-code-line">&nbsp;</div>
        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4 err-code text-center">
            <b>{{ $code }}</b>
        </div>
        <div class="hidden-xs col-sm-2 col-md-3 col-lg-3 err-code-line">&nbsp;</div>
    </div>
    <div class="row" id="err-title">
        <div class="col-xs-offset-1 col-xs-10 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6 col-lg-offset-4 col-lg-4 text-center">
            @if($code != 500 && $code != 404 && $code != 403 && $code != 400 && $code != 401)
            <b>@lang('error.oops')</b> @lang('error.default.title')
            @else
            <b>@lang('error.oops')</b> @lang('error.'.$code.'.title')
            @endif
        </div>
    </div>
    <div class="row" id="err-subtitle">
        <div class="col-xs-offset-1 col-xs-10 col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6 col-lg-offset-4 col-lg-4 text-center">
            @if($code != 500 && $code != 404 && $code != 403 && $code != 400 && $code != 401)
            <b><i>@lang('error.default.subtitle')</i></b>
            @else
            <b><i>@lang('error.'.$code.'.subtitle')</i></b>
            @endif
        </div>
    </div>
    <div class="row" id="err-options">
        <div class="col-xs-12 text-center">
        @if($code==404) {{--Offer home link--}}
            <a href="{{ route('home') }}" class="btn btn-primary btn-md">@lang('error.home')</a>
        @else {{--Offer contact form--}}
            <a href="{{ route('contact') }}" class="btn btn-primary btn-md">@lang('error.contact')</a>
        @endif
        </div>
    </div>
</div>
@endsection

@section('page_js')

@endsection