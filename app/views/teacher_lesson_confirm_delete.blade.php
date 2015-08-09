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

            <div><h1 class="generic-title">@lang('lesson_confirm_delete.title')</h1></div>

            <div><h2 class="generic-subtitle">@lang('lesson_confirm_delete.subtitle')</h2></div>

        </div>
    </div>
    <div class="container-fluid bottom-padding-80 background-gblack overflow-allowed">
        <div class="container generic-box top-padding-50 bottom-padding-150 magic-align">

            <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8">

                <h3>@lang('lesson_confirm_delete.are_u_sure')</h3>
                <div class="top-buffer-25">
                    <ul>
                        <li>@lang('lesson_confirm_delete.warning1')</li>
                        <li>@lang('lesson_confirm_delete.warning2')</li>
                    </ul>
                </div>
                <div class="top-buffer-25">
                    <form action="{{ action('TeachersController@doDeleteLesson') }}" method="post" role="form">
                        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                        <input type="hidden" name="lesson_id" value="{{ $lesson->id }}"/>
                        <input type="submit" class="btn btn-danger" value="@lang('buttons.confirm')"/>
                        <a href="{{ route('userpanel.dashboard') }}" class="btn btn-default">@lang('buttons.cancel')</a>
                    </form>
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
