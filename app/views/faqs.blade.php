@extends('layout')
@section('content')

    <div class="container-fluid top-padding-70 bottom-padding-150 background-lamp">
        <div class="container">

            <div><h1 class="generic-title">@lang('faqs.title')</h1></div>

            <div><h2 class="generic-subtitle">@lang('faqs.subtitle')</h2></div>

        </div>
    </div>
    <div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
        <div class="container generic-box top-padding-50 bottom-padding-50 magic-align">

            <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8">
                <div class="row faqs-question">@lang('faqs.question1')</div>
                <div class="row">@lang('faqs.answer1')</div>
                <div class="row faqs-question">@lang('faqs.question2')</div>
                <div class="row">@lang('faqs.answer2')</div>
                <div class="row faqs-question">@lang('faqs.question3')</div>
                <div class="row">@lang('faqs.answer3')</div>
                <div class="row faqs-question">@lang('faqs.question4')</div>
                <div class="row">@lang('faqs.answer4')</div>

                <div class="row text-center top-buffer-25">
                    <hr class="hr-faqs">
                </div>
                <div class="row text-center">
                    <a href="{{ url('contacta') }}" class="btn input-lg faqs-btn">@lang('faqs.doubts')</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid background-gblack">
        <hr class="hr-page-end"/>
    </div>

@endsection