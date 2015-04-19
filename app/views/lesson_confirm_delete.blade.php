@extends('layout')
@section('content')
<div class="container top-buffer-15 bottom-buffer-45">
    <div class="page-header">
        <h1>@lang('course_confirm_delete.are_u_sure') {{ $school->name }}?</h1>
    </div>
    <div class="container">
        <ul>
            <li>@lang('course_confirm_delete.warning1')</li>
            <li>@lang('course_confirm_delete.warning2')</li>
        </ul>
    </div>
    <div class="container top-buffer-15">
        <form action="{{ action('AdminController@deleteLesson') }}" method="post" role="form">
            <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
            <input type="hidden" name="school_id" value="{{ $school->id }}"/>
            <input type="hidden" name="lesson_id" value="{{ $lesson->id }}"/>
            <input type="submit" class="btn btn-danger" value="@lang('buttons.confirm')"/>
            <a href="{{ url('admin/lessons',$school->id) }}" class="btn btn-default">@lang('buttons.cancel')</a>
        </form>
    </div>
</div>
@stop