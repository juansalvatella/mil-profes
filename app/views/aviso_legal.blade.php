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
            <div><h1 class="generic-title">@lang('aviso_legal.title')</h1></div>
            <div><h2 class="generic-subtitle">@lang('aviso_legal.subtitle')</h2></div>
        </div>
    </div>
    <div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
        <div class="container generic-box top-padding-50 bottom-padding-50 magic-align">
            <div class="row">
                <div class="col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-10 who-padding">
                    <p class="full-width text-justify">@lang('aviso_legal.p1')</p>
                    <h3>@lang('aviso_legal.t2')</h3>
                    <p class="full-width text-justify">@lang('aviso_legal.p2')</p>
                    <h3>@lang('aviso_legal.t3')</h3>
                    <p class="full-width text-justify">@lang('aviso_legal.p3')</p>
                    <h3>@lang('aviso_legal.t4')</h3>
                    <p class="full-width text-justify">@lang('aviso_legal.p4')</p>
                    <h4>@lang('aviso_legal.t5')</h4>
                    <p class="full-width text-justify">@lang('aviso_legal.p5')</p>
                    <h4>@lang('aviso_legal.t6')</h4>
                    <p class="full-width text-justify">@lang('aviso_legal.p6')</p>
                    <h4>@lang('aviso_legal.t7')</h4>
                    <p class="full-width text-justify">@lang('aviso_legal.p7')</p>
                    <h4>@lang('aviso_legal.t8')</h4>
                    <p class="full-width text-justify">@lang('aviso_legal.p8')</p>
                    <h4>@lang('aviso_legal.t9')</h4>
                    <p class="full-width text-justify">@lang('aviso_legal.p9')</p>
                    <h4>@lang('aviso_legal.t10')</h4>
                    <p class="full-width text-justify">@lang('aviso_legal.p10')</p>
                    <h3>@lang('aviso_legal.t11')</h3>
                    <p class="full-width text-justify">@lang('aviso_legal.p11')</p>
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
