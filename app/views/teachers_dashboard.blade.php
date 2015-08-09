@extends('layout')

@section('page_meta')

@endsection

@section('page_head')

@endsection

@section('page_css')

@endsection

@section('content')

{{--token needed for ajax POST requests--}}
<input id="token" type="hidden" name="_token" value="{{{ Session::getToken() }}}"/>

<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="pull-left">
                <h1>@lang('teacher-dashboard.teachers') <small>@lang('teacher-dashboard.dashboard')</small></h1>
            </div>
            <div class="pull-right">
                <a href="{{ route('userpanel.dashboard') }}" class="btn btn-default"><i class="fa fa-chevron-left"></i> @lang('buttons.back')</a>
            </div>
        </div>
    </div>
</div>

<div class="container">

    @if ($users->isEmpty())
    <p>There are no teachers... yet?</p>
    @else
    {{ $users->links() }}
    <table class="table table-striped">
        <thead>
        <tr>
            <th width="80">@lang('teacher-dashboard.picture')</th>
            <th>@lang('teacher-dashboard.name')</th>
            <th>@lang('teacher-dashboard.email')</th>
            <th>@lang('teacher-dashboard.created-at')</th>
            <th width="80">@lang('teacher-dashboard.profile')</th>
            <th width="80">@lang('teacher-dashboard.delete')</th>
        </tr>
        </thead>
        <tbody id="teachers">
        @foreach($users as $user)
        <tr>
            <input type="hidden" class="user-id" value="{{ $user->id }}" />
            <td>
                <img src="{{ asset('img/avatars/'.$user->avatar) }}" height="40" width="40"/>
            </td>
            <td>
                {{ $user->name }}
            </td>
            <td>
                {{ $user->email }}
            </td>
            <td>
                {{ $user->created_at }}
            </td>
            <td>
            <?php $eloqUser = User::findOrFail($user->id); ?>
                @if($eloqUser->hasRole("teacher"))
                <a href="{{ route('profiles-teacher',$user->slug) }}" class="btn btn-sm btn-info"><i class="fa fa-link"></i>@lang('teacher-dashboard.see-profile')</a>
            @endif
            </td>
            <td>
                <a href="{{ route('show.delete.teacher',$user->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> <span class="hidden-xs">@lang('teacher-dashboard.delete')</span></a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div class="panel panel-default">
        <div class="panel-body">
            @lang('teacher-dashboard.showing') {{ $users->getFrom() }}-{{ $users->getTo() }} @lang('teacher-dashboard.from-total') {{ $users->getTotal() }} @choice('of-teachers',$users->getTotal()).
        </div>
    </div>
    {{ $users->links() }}
    @endif

</div>

@endsection

@section('page_js')

@endsection
