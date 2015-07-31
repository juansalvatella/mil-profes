@extends('layout')

@section('page_meta')

@endsection

@section('page_head')

@endsection

@section('page_css')

@endsection

@section('content')

    <div class="container top-buffer-15 bottom-buffer-45">
    <div class="page-header">
        <h1>@lang('teacher_confirm_delete.title') {{ $user->name }}?</h1>
    </div>
    <div class="container">
        <ul>
            <li>@lang('teacher_confirm_delete.warning1')</li>
            <li>@lang('teacher_confirm_delete.warning2')</li>
            <li>@lang('teacher_confirm_delete.warning3')</li>
        </ul>
    </div>
    <div class="container" class="top-buffer-15">
        <form action="{{ action('AdminController@deleteUser') }}" method="post" role="form">
            <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
            <input type="hidden" name="id" value="{{ $user->id }}"/>
            <input type="submit" class="btn btn-danger" value="@lang('teacher_confirm_delete.confirm')"/>
            <a href="{{ url('admin/teachers') }}" class="btn btn-default">@lang('teacher_confirm_delete.cancel')</a>
        </form>
    </div>
</div>

@endsection

@section('page_js')

@endsection
